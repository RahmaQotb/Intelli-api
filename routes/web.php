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

Route::controller(CategoryController::class)->prefix('categories')->group(function () {
    Route::get("/create", "create");
    Route::post("/", "store")->name("Store");
    Route::get("/", "index");
    Route::get("/show/{id}", "show")->name("show");
    Route::get("/edit/{id}", "edit");
    Route::put("/{id}", "update");
    Route::delete("/{id}", "destroy")->name('destroy');
});
