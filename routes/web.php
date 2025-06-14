<?php

use App\Http\Controllers\Dashboard\Auth\AuthController;
use App\Http\Controllers\Dashboard\BrandAdminController;
use App\Http\Controllers\Dashboard\BrandController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\SubCategoryController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\AdminController;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', function () {
    $categories = Category::count();
        $sub_categories = SubCategory::count();
        $products = Product::count();
        $model_counts = [
            "categories" => $categories,
            "sub_categories" => $sub_categories,
            "products" => $products
        ];
        return view('Dashboard.index', compact("model_counts"));
    // return redirect()->route('dashboard.index');
})->name('index')->middleware('authenticated');

Route::as('dashboard.')->group(function () {

    Route::controller(AuthController::class)->as('auth.')->group(function(){
            Route::middleware('guest')->group(function(){
                Route::get('login',"getLogin")->name('login_form');
                Route::post('login',"login")->name('login');
            });
            Route::post('logout',"logout")->name('logout')->middleware('authenticated');
    });

Route::middleware('authenticated')->group(function(){

    Route::get('/index', function () {
        return redirect()->route('index');
    })->name('index');

    // categoreis
    Route::resource('categories', CategoryController::class)->except(['update']);
    Route::post('categories/{category}/edit', [CategoryController::class, 'update'])->name('categories.update');


    //sub categories
    Route::resource('sub_categories', SubCategoryController::class)->except(['update']);
    Route::post('sub_categories/{sub_category}/edit', [SubCategoryController::class, 'update'])->name('sub_categories.update');


    //products
    Route::resource('products', ProductController::class)/*->except(['update'])*/;

    //Brand
        Route::resource('brands', BrandController::class)->only(['index', 'create', 'store', 'show', 'destroy']);
        Route::get('brands/admin/create', [BrandController::class, 'createAdmin'])->name('brands.admin.create');
        Route::post('brands/admin', [BrandController::class, 'storeAdmin'])->name('brands.admin.store');

    Route::controller(AdminController::class)->as('admin.')->group(function () {
        Route::get('add-admin', 'create')->name('create');
        Route::post('add_admin', 'add')->name('add');
        Route::get('change-password', 'changePasswordForm')->name('change_password_form');
        Route::post('change-password', 'changePassword')->name('change_password');
    });
});
});
