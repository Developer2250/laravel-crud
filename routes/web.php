<?php

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
    return redirect()->route('login');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/products', [App\Http\Controllers\ProductController::class, 'index'])->name('product');

    Route::post('/product/add', [App\Http\Controllers\ProductController::class, 'store'])->name('product.store');

    Route::get('/products/delete/all', [App\Http\Controllers\ProductController::class, 'destroyAllProduct'])->name('product.all.delete');

    Route::post('/products/update/status', [App\Http\Controllers\ProductController::class, 'updateProductStatus'])->name('product.status.update');

    Route::get('/history', [App\Http\Controllers\ProductController::class, 'getProductHistory'])->name('history');

    Route::get('/users', [App\Http\Controllers\UserController::class, 'getUsersData'])->name('users');

    //category
    Route::get('/categories', [App\Http\Controllers\CategoryController::class, 'index'])->name('categories');
    Route::post('/store-category', [App\Http\Controllers\CategoryController::class, 'store'])->name('category.store');
    Route::get('/delete-all-records', [App\Http\Controllers\CategoryController::class, 'destroyAllCategories'])->name('categories.all.delete');
    Route::post('/update-status', [App\Http\Controllers\CategoryController::class, 'updateCategoryStatus'])->name('category.status.update');
    Route::get('/category/{id}', [App\Http\Controllers\CategoryController::class, 'getCategory'])->name('category.get');
    Route::post('/category/update/{id}', [App\Http\Controllers\CategoryController::class, 'update'])->name('category.update');
    Route::post('/category/delete/{id}', [App\Http\Controllers\CategoryController::class, 'destroy'])->name('category.delete');
    Route::get('/category/product/view', [App\Http\Controllers\CategoryController::class, 'getCategoryProduct'])->name('category.product.view');


    Route::get('/category/activity/log', [App\Http\Controllers\CategoryController::class, 'getCategoryActivityLog'])->name('category.activity.log');

    Route::get('/get-history-data/{id}',[App\Http\Controllers\CategoryController::class, 'getCategorySingleLogData'])->name('get-history-data');
    
});
