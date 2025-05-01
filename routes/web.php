<?php


use App\Http\Controllers\Dashboard\CategoryController;
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

Route::get('/dashboard', function () {
    return view('Admin.home');
})->name('dashboard');

Route::controller(CategoryController::class)->group(function () {
    Route::get("categories/create", "create");
    Route::post("categories/", "store")->name("Store");
    Route::get("categories/", "index");
    Route::get("categories/show/{id}", "show");
    Route::get("categories/edit/{id}", "edit");
    Route::put("categories/{id}", "update");
    Route::delete("categories/{id}", "delete");
});
