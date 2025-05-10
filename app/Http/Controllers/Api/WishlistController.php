<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\WishlistResource;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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
        $validated = Validator::make($request->all(),[
            'product_id' => 'required|exists:products,id',
        ]);
        if($validated->fails()){
            return response()->json([
                'status'=>false,
                'message' => 'The product not exist'
            ], 404);
        }
        $userId = $request->user();


        $existingWishlist = Wishlist::where('user_id', $userId->id)
            ->where('product_id', $request->product_id)
            ->first();

        if ($existingWishlist) {
            return response()->json([
                'message' => 'The product is already in your wishlist.'
            ], 400);
        }

        $wishlistItem = Wishlist::create([
            'user_id' => $userId->id,
            'product_id' => $request->product_id
        ])->load('product');

        return response()->json([
            'message' => 'Product added to wishlist successfully.',
            'data'=>new WishlistResource($wishlistItem)
        ], 200);
    }


   public function removeFromWishlist($product_id)
{
    $userId = request()->user();


    $wishlistItem = Wishlist::where('user_id', $userId->id)
        ->where('product_id', $product_id)
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
            $userId = request()->user();

        $wishlistItems = Wishlist::with('product')->where('user_id', $userId->id)->get();


        if ($wishlistItems->isEmpty()) {
            return response()->json([
                'status'=>false,
                'message' => 'Products not found in your wishlist.'
            ], 404);
        }

        return response()->json([
                'status'=>true,
                'message' => 'Products retrived successfully.',
                'data'=>WishlistResource::collection($wishlistItems)
        ]);
    }
}


