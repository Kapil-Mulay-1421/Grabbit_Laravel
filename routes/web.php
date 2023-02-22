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
    return redirect('/home');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/localproduce', [App\Http\Controllers\ProductController::class, 'localproduce']);

Route::get('/deals', [App\Http\Controllers\ProductController::class, 'index']);

Route::get('/categories/{category}', [App\Http\Controllers\CategoryController::class, 'show']);

Route::get('/products/{productName}', [App\Http\Controllers\ProductController::class, 'show']);

Route::get('/cart', [App\Http\Controllers\CartItemController::class, 'index'])->middleware('auth');

Route::get('/cart/json', [App\Http\Controllers\CartItemController::class, 'indexJson'])->middleware('auth');

Route::get('/profile/{tab}', [App\Http\Controllers\ProfileController::class, 'index'])->middleware('auth');

Route::get('/profile/orders/{id}', [App\Http\Controllers\OrderController::class, 'show'])->middleware('auth');

Route::get('/profile/addresses/create', [App\Http\Controllers\CustomerAddressController::class, 'create'])->middleware('auth');

Route::get('/profile/addresses/{id}/edit', [App\Http\Controllers\CustomerAddressController::class, 'edit'])->middleware('auth');

Route::put('/profile/addresses/{id}', 'App\Http\Controllers\CustomerAddressController@setActive')->middleware('auth');

Route::delete('/profile/addresses/{id}', 'App\Http\Controllers\CustomerAddressController@destroy')->middleware('auth');

Route::post('/profile/addresses', 'App\Http\Controllers\CustomerAddressController@store')->middleware('auth');

Route::post('/profile/addresses/{id}/edit', 'App\Http\Controllers\CustomerAddressController@update')->middleware('auth'); // using traditional form here, doesn't allow put, so using post.

Route::post('/cart', 'App\Http\Controllers\CartItemController@add')->middleware('auth');

Route::post('/product/save', 'App\Http\Controllers\ProductController@addToCartOrWishlist')->middleware('auth');

Route::post('/profile/account/edit', 'App\Http\Controllers\CustomerController@update')->middleware('auth');

Route::get('/cart/{id}/delete', [App\Http\Controllers\CartItemController::class, 'destroy'])->middleware('auth');

Route::post('/subscribers', [App\Http\Controllers\SubscriberController::class, 'store']);

Route::get('/stores/sellers', [App\Http\Controllers\ShopwiseProductController::class, 'fetchStoresForProducts'])->middleware('auth'); // Will be called at runtime from client side script (cart.js).

Route::post('/checkout', [App\Http\Controllers\CartItemController::class, 'checkout'])->middleware('auth');

Route::get('/customerSupport', function() {
    return view('customerSupport');
});

Route::post('/queries', [App\Http\Controllers\QueryController::class, 'store'])->middleware('auth');

Route::post('/payment-verification', [App\Http\Controllers\OrderController::class, 'verifyAndCreateOrder']);

Route::get('/stripe-success', [App\Http\Controllers\OrderController::class, 'handlePaymentSuccess']);

Route::post('/webhook', [App\Http\Controllers\OrderController::class, 'webhook']);

Route::get('/terms-and-conditions', function() {
    return view('termsAndConditions');
});

Route::get('/privacy-policy', function() {
    return view('privacyPolicy');
});

Route::get('/cancellation-refund-policy', function() {
    return view('cancellationRefundPolicy');
});

Route::post('/search', [App\Http\Controllers\ProductController::class, 'handleSearch']);

Route::get('/search', function() {
    return redirect('/home');
});

Route::post('/feedback', [App\Http\Controllers\FeedbackController::class, 'store'])->middleware('auth');
