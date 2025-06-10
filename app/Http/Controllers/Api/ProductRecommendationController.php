<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\SearchHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Traits\HasProductRecommendations;

class ProductRecommendationController extends Controller
{
    use HasProductRecommendations;

    public function searchProducts(Request $request)
    {
        try {
            $request->validate([
                'search' => 'required|string|min:2'
            ]);

            $searchQuery = $request->input('search');
            $user = Auth::user();

            $searchedProducts = Product::where('name', 'like', "%{$searchQuery}%")
                ->orWhere('description', 'like', "%{$searchQuery}%")
                ->get();

            if (!$searchedProducts->isEmpty()) {
                $categoryId = $searchedProducts->first()->category_id;
                SearchHistory::create([
                    'user_id' => $user->id,
                    'search_query' => $searchQuery,
                    'category_id' => $categoryId
                ]);
            }

            if ($searchedProducts->isEmpty()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'No products found for the search query',
                    'data' => []
                ], 200);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Products retrieved successfully',
                'data' => ProductResource::collection($searchedProducts)
            ], 200);
        } catch (\Exception $e) {
            Log::error('Search error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while searching for products',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getRecommendationsForProduct(Request $request)
    {
        try {
            $request->validate([
                'product_id' => 'required|exists:products,id'
            ]);

            $productId = $request->input('product_id');
            $product = Product::findOrFail($productId);

            $recommendedProducts = Product::where('category_id', $product->category_id)
                ->where('status', 'active')
                ->where('id', '!=', $productId)
                ->inRandomOrder()
                ->limit(10)
                ->get();

            return response()->json([
                'status' => 'success',
                'message' => $recommendedProducts->isEmpty() ?
                    'No recommendations found for this product' :
                    'Recommendations retrieved successfully',
                'data' => ProductResource::collection($recommendedProducts)
            ], 200);
        } catch (\Exception $e) {
            Log::error('Product recommendation error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while fetching recommendations for the product',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getAllRecommendations(Request $request)
    {
        try {
            $user = Auth::user();

            $wishlistProducts = $this->getWishlistProducts($user);
            $wishlistCategoryIds = $this->getTopCategoriesFromProducts($wishlistProducts);

            $searchedProducts = $this->getSearchHistoryProducts($user);
            $searchCategoryIds = $this->getTopCategoriesFromProducts($searchedProducts);

            // dd([
            //     'wishlistCategoryIds' => $wishlistCategoryIds,
            //     'searchCategoryIds' => $searchCategoryIds,
            // ]);


            $combinedCategoryIds = $wishlistCategoryIds
                ->merge($searchCategoryIds)
                ->unique();
            // dd($combinedCategoryIds);
            $excludedProducts = $wishlistProducts
                ->merge($searchedProducts)
                ->unique('id');
            // dd($excludedProducts->count());

            $excludedProductIds = $excludedProducts->pluck('id');

            $recommendedProducts = $this->getRecommendedProductsByCategoryIds($combinedCategoryIds, $excludedProductIds);

            return response()->json([
                'status' => 'success',
                'message' => $recommendedProducts->isEmpty()
                    ? 'No recommendations available'
                    : 'Recommendations retrieved successfully',
                'data' => ProductResource::collection($recommendedProducts)
            ], 200);
        } catch (\Exception $e) {
            Log::error('All recommendations error: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while fetching all recommendations',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
