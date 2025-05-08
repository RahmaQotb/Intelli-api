from fastapi import FastAPI, Query
import pandas as pd
import requests
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.metrics.pairwise import cosine_similarity

app = FastAPI()

PRODUCTS_API = "http://127.0.0.1:8000/api/products"

products = pd.DataFrame()
vectorizer = TfidfVectorizer(stop_words='english')
tfidf_matrix = None


def load_data_from_api():
    global products, tfidf_matrix

    # Fetch data
    response = requests.get(PRODUCTS_API)
    products = pd.DataFrame(response.json())

    # Handle category if nested
    if 'category' in products.columns and isinstance(products['category'].iloc[0], dict):
        products['category_name'] = products['category'].apply(lambda x: x.get('name', '') if isinstance(x, dict) else '')
    else:
        products['category_name'] = products['category'].astype(str)

    # Combine content
    products['content'] = (
        products['name'].astype(str) + ' ' +
        products['description'].astype(str) + ' ' +
        products['category_name'] + ' ' +
        products['brand'].astype(str) + ' ' +
        products['features'].astype(str)
    )

    # Build TF-IDF
    tfidf_matrix = vectorizer.fit_transform(products['content'])


@app.on_event("startup")
def startup_event():
    load_data_from_api()


@app.get("/recommend/search")
def recommend_search(query: str, n: int = 5):
    query_vec = vectorizer.transform([query])
    scores = cosine_similarity(query_vec, tfidf_matrix).flatten()
    top_indices = scores.argsort()[::-1][:n]
    return products.iloc[top_indices].to_dict(orient='records')


@app.get("/recommend/similar/{product_id}")
def recommend_similar(product_id: int, n: int = 5):
    index = products[products['id'] == product_id].index
    if len(index) == 0:
        return []
    index = index[0]
    scores = cosine_similarity(tfidf_matrix[index], tfidf_matrix).flatten()
    top_indices = scores.argsort()[::-1][1:n+1]
    return products.iloc[top_indices].to_dict(orient='records')


@app.post("/refresh")
def refresh_data():
    load_data_from_api()
    return {"status": "refreshed", "total_products": len(products)}
