<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Auth\ResetPassController;
use App\Http\Controllers\Api\BrandController as ApiBrandController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ProductRecommendationController;
use App\Http\Controllers\Dashboard\BrandController;
use App\Http\Controllers\RecommendationController;
use App\Http\Controllers\Api\WishlistController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/search', [ProductRecommendationController::class, 'searchProducts']);
    Route::get('/recommendations-for-product', [ProductRecommendationController::class, 'getRecommendationsForProduct']);
    Route::get('/all-recommendations', [ProductRecommendationController::class, 'getAllRecommendations']);
});

Route::prefix('auth')->name('auth.')->controller(AuthController::class)->group(function () {
    Route::post("register", "register")->name('register');
    Route::post("login", "login")->name('login');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post("logout", "logout")->name('logout');
        Route::post('change-password', 'changePassword')->name('change-password');
    });
});

Route::prefix('auth')->name('auth.')->controller(ResetPassController::class)->group(function () {
    Route::post('forgot-password', 'forgotPassword')->name('forgot-password');
    Route::post('verify-reset-code', 'verifyResetCode')->name('verify-reset-code');
    Route::post('reset-password', 'resetPassword')->name('reset-password');
});

Route::prefix('categories')->name('categories.')->controller(CategoryController::class)->group(function () {
    Route::get('get-categories', 'getCategories')->name('index');
    Route::get('categories/{id}', 'getCategoryById')->name('show');
});

Route::prefix('products')->name('products.')->controller(ProductController::class)->group(function () {
    Route::get('/', 'index')->name('all');
    Route::get('product/{slug}', 'getProduct')->name('show');
    Route::get('category/{category_slug}', 'getProductsByCategory')->name('by-category');
    Route::get('category/{category_slug}/{sub_category_slug}', 'getProductsByCategoryAndSubCat')->name('by-sub-category');
    Route::get('brand/{brand_slug}', 'getProductsByBrand')->name('by-brand');
});

Route::middleware('auth:sanctum')->prefix('cart')->name('cart.')->controller(CartController::class)->group(function () {
    Route::post('add', 'addToCart')->name('add');
    Route::post('remove', 'removeFromCart')->name('remove');
    Route::delete('delete', 'deleteCart')->name('delete');
    Route::get('/', 'getCart')->name('get');
});
Route::middleware('auth:sanctum')
    ->prefix('order')
    ->name('order.')
    ->controller(OrderController::class)
    ->group(function () {
        Route::post('checkout', 'checkout')->name('checkout');
        Route::post('{order}/cancel', 'cancel')->whereNumber('order')->name('cancel');
        Route::get('', 'index')->name('index');
        Route::get('{order}', 'show')->whereNumber('order')->name('show');
    });
Route::post('brands', [BrandController::class, 'store'])->name('brands.store');
Route::get('brands', [ApiBrandController::class, 'index'])->name('brands');

Route::middleware('auth:sanctum')->controller(WishlistController::class)->group(function () {
    Route::post('/wishlist', 'addToWishlist');
    Route::delete('/wishlist/{product_id}', 'removeFromWishlist');
    Route::delete('/wishlist', 'clearWishlist');
    Route::get('/wishlist', 'getWishlist');
});
