<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\SearchHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ProductRecommendationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */


    /**
     * Search for products based on query
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
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
                ->where('status', 'active')
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

    /**
     * Get recommendations for a specific product (same category)
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
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

            if ($recommendedProducts->isEmpty()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'No recommendations found for this product',
                    'data' => []
                ], 200);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Recommendations for product retrieved successfully',
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

    /**
     * Get all personalized recommendations for the user
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllRecommendations(Request $request)
    {
        try {
            $user = Auth::user();

            $frequentCategoryIds = SearchHistory::where('user_id', $user->id)
                ->groupBy('category_id')
                ->select('category_id')
                ->orderByRaw('COUNT(*) DESC')
                ->pluck('category_id')
                ->take(3);

            $recommendedProducts = collect();
            if ($frequentCategoryIds->isNotEmpty()) {
                $recommendedProducts = Product::whereIn('category_id', $frequentCategoryIds)
                    ->where('status', 'active')
                    ->inRandomOrder()
                    ->limit(10)
                    ->get();
            } else {
                $recommendedProducts = Product::where('status', 'active')
                    ->inRandomOrder()
                    ->limit(10)
                    ->get();
            }

            if ($recommendedProducts->isEmpty()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'No recommendations available',
                    'data' => []
                ], 200);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'All personalized recommendations retrieved successfully',
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