<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/localproduce', [App\Http\Controllers\ProductController::class, 'localproduce']);

Route::get('/deals', [App\Http\Controllers\ProductController::class, 'index']);

Route::get('/categories/{category}', [App\Http\Controllers\CategoryController::class, 'show']);

Route::get('/products/{productName}', [App\Http\Controllers\ProductController::class, 'show']);

Route::get('/cart', [App\Http\Controllers\CartItemController::class, 'index']);

Route::get('/profile/{tab}', [App\Http\Controllers\ProfileController::class, 'index']);

Route::get('/profile/addresses/create', [App\Http\Controllers\CustomerAddressController::class, 'create']);

Route::get('/profile/addresses/{id}/edit', [App\Http\Controllers\CustomerAddressController::class, 'edit']);

Route::put('/profile/addresses/{id}', 'App\Http\Controllers\CustomerAddressController@setActive');

Route::delete('/profile/addresses/{id}', 'App\Http\Controllers\CustomerAddressController@destroy');

Route::post('/profile/addresses', 'App\Http\Controllers\CustomerAddressController@store');

Route::post('/profile/addresses/{id}/edit', 'App\Http\Controllers\CustomerAddressController@update'); // using traditional form here, doesn't allow put, so using post.

Route::post('/cart', 'App\Http\Controllers\CartItemController@add');

Route::post('/product/save', 'App\Http\Controllers\ProductController@addToCartOrWishlist');

Route::post('/profile/account/edit', 'App\Http\Controllers\CustomerController@update');

Route::delete('/cart/{id}', [App\Http\Controllers\CartItemController::class, 'destroy']);