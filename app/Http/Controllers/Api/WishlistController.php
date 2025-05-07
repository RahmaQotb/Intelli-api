<?php

namespace App\Http\Controllers;

use App\Http\Resources\WishlistResource;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    /**
     * Add product to the user's wishlist.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addToWishlist(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $userId = Auth::id();  

        $existingWishlist = Wishlist::where('user_id', $userId)
            ->where('product_id', $request->product_id)
            ->first();

        if ($existingWishlist) {
            return response()->json([
                'message' => 'The product is already in your wishlist.'
            ], 400);
        }

        Wishlist::create([
            'user_id' => $userId,
            'product_id' => $request->product_id
        ]);

        return response()->json([
            'message' => 'Product added to wishlist successfully.'
        ], 200);
    }

 
    public function removeFromWishlist(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $userId = Auth::id();  

        $wishlistItem = Wishlist::where('user_id', $userId)
            ->where('product_id', $request->product_id)
            ->first();

        if (!$wishlistItem) {
            return response()->json([
                'message' => 'Product not found in your wishlist.'
            ], 404);
        }

        $wishlistItem->delete();

        return response()->json([
            'message' => 'Product removed from wishlist successfully.'
        ], 200);
    }


    public function getWishlist()
    {
        $userId = Auth::id();

        $wishlistItems = Wishlist::with('product')->where('user_id', $userId)->get();

        return WishlistResource::collection($wishlistItems);
    }
}
        

