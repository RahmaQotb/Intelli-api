from fastapi import FastAPI, Query
import pandas as pd
import requests
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.metrics.pairwise import cosine_similarity
import logging

app = FastAPI()

# Configure logging
logging.basicConfig(level=logging.INFO)
logger = logging.getLogger(__name__)

# Use Hostinger Laravel API
PRODUCTS_API = "https://beige-alligator-527710.hostingersite.com/public/api/products"

products = pd.DataFrame()
vectorizer = TfidfVectorizer(stop_words='english')
tfidf_matrix = None

def load_data_from_api():
    global products, tfidf_matrix
    try:
        # Fetch data with error handling
        response = requests.get(PRODUCTS_API, timeout=10)
        response.raise_for_status()  # Raise exception for bad status codes
        data = response.json()

        # Handle Laravel's 'data' key
        products = pd.DataFrame(data.get('data', []))

        if products.empty:
            logger.warning("No products fetched from API")
            return

        # Handle category if nested
        if 'category' in products.columns and products['category'].notnull().any():
            products['category_name'] = products['category'].apply(
                lambda x: x.get('name', '') if isinstance(x, dict) else str(x)
            )
        else:
            products['category_name'] = products.get('category', '')

        # Handle brand if nested
        if 'brand' in products.columns and products['brand'].notnull().any():
            products['brand_name'] = products['brand'].apply(
                lambda x: x.get('name', '') if isinstance(x, dict) else str(x)
            )
        else:
            products['brand_name'] = products.get('brand', '')

        # Combine content
        products['content'] = (
            products['name'].astype(str) + ' ' +
            products['description'].astype(str) + ' ' +
            products['category_name'].astype(str) + ' ' +
            products['brand_name'].astype(str) + ' ' +
            products['features'].astype(str)
        )

        # Build TF-IDF
        tfidf_matrix = vectorizer.fit_transform(products['content'])
        logger.info(f"Loaded {len(products)} products and built TF-IDF matrix")
    except requests.RequestException as e:
        logger.error(f"Failed to fetch products from API: {e}")
        products = pd.DataFrame()
        tfidf_matrix = None

@app.on_event("startup")
def startup_event():
    load_data_from_api()

@app.get("/recommend/search")
def recommend_search(query: str = Query(..., min_length=1, max_length=255), n: int = 5):
    if products.empty or tfidf_matrix is None:
        logger.warning("No product data available for search")
        return []
    
    try:
        query_vec = vectorizer.transform([query])
        scores = cosine_similarity(query_vec, tfidf_matrix).flatten()
        top_indices = scores.argsort()[::-1][:n]
        result = products.iloc[top_indices].to_dict(orient='records')
        logger.info(f"Search query '{query}' returned {len(result)} results")
        return result
    except Exception as e:
        logger.error(f"Error processing search query '{query}': {e}")
        return []

@app.get("/recommend/similar/{product_id}")
def recommend_similar(product_id: int, n: int = 5):
    if products.empty or tfidf_matrix is None:
        logger.warning("No product data available for similar recommendations")
        return []
    
    try:
        index = products[products['id'] == product_id].index
        if len(index) == 0:
            logger.warning(f"Product ID {product_id} not found")
            return []
        index = index[0]
        scores = cosine_similarity(tfidf_matrix[index], tfidf_matrix).flatten()
        top_indices = scores.argsort()[::-1][1:n+1]
        result = products.iloc[top_indices].to_dict(orient='records')
        logger.info(f"Similar recommendations for product ID {product_id} returned {len(result)} results")
        return result
    except Exception as e:
        logger.error(f"Error processing similar recommendation for product ID {product_id}: {e}")
        return []

@app.post("/refresh")
def refresh_data():
    load_data_from_api()
    return {"status": "refreshed", "total_products": len(products)}