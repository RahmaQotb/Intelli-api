<?php

namespace App\Traits;

use App\Models\Product;
use Illuminate\Support\Collection;

trait HasProductRecommendations
{
    public function getWishlistProducts($user): Collection
    {
        return $user->wishlists()
            ->with('product')
            ->get()
            ->pluck('product')
            ->filter(function ($product) {
                return $product && $product->status === 'active';
            });
    }

    public function getSearchHistoryProducts($user): Collection
    {
        $searchCategoryIds = $user->searchHistories()
            ->latest()
            ->pluck('category_id')
            ->unique()
            ->filter();


        $products = collect();

        foreach ($searchCategoryIds as $categoryId) {
            $productsInCategory = Product::where('category_id', $categoryId)
                ->where('status', 'active')
                ->take(2)
                ->get();

            $products = $products->merge($productsInCategory);
        }

        return $products;
    }


    public function getOrderProducts($user): Collection
    {
        return Product::whereHas('orderItems.order', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->where('status', 'active')->get();
    }

    public function getTopCategoriesFromProducts(Collection $products): Collection
    {
        return $products->pluck('category_id')
            ->filter()
            ->countBy()
            ->sortDesc()
            ->keys();
    }


    public function getRecommendedProductsByCategoryIds(Collection $categoryIds, Collection $excludedProductIds): Collection
    {
        return Product::whereIn('category_id', $categoryIds->flatten())
            ->where('status', 'active')
            ->whereNotIn('id', $excludedProductIds->flatten())
            ->inRandomOrder()
            ->take(10)
            ->get();
    }
}
