<?php

use Illuminate\Support\Facades\Route;

use Illuminate\Foundation\Auth\EmailVerificationRequest;

use Illuminate\Http\Request;

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

Route::get('/email/verify', function () {
    return view('auth.verify');
})->middleware('auth')->name('verification.notice');
 
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
 
    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');
 
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
 
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/localproduce', [App\Http\Controllers\ProductController::class, 'localproduce']);

Route::get('/deals', [App\Http\Controllers\ProductController::class, 'index']);

Route::get('/categories/{category}', [App\Http\Controllers\CategoryController::class, 'show']);

Route::get('/products/{productName}', [App\Http\Controllers\ProductController::class, 'show']);

Route::get('/cart', [App\Http\Controllers\CartItemController::class, 'index'])->middleware('verified');

Route::get('/cart/json', [App\Http\Controllers\CartItemController::class, 'indexJson'])->middleware('verified');

Route::get('/profile/{tab}', [App\Http\Controllers\ProfileController::class, 'index'])->middleware('verified');

Route::get('/profile/orders/{id}', [App\Http\Controllers\OrderController::class, 'show'])->middleware('verified');

Route::get('/profile/addresses/create', [App\Http\Controllers\CustomerAddressController::class, 'create'])->middleware('verified');

Route::get('/profile/addresses/{id}/edit', [App\Http\Controllers\CustomerAddressController::class, 'edit'])->middleware('verified');

Route::put('/profile/addresses/{id}', 'App\Http\Controllers\CustomerAddressController@setActive')->middleware('verified');

Route::delete('/profile/addresses/{id}', 'App\Http\Controllers\CustomerAddressController@destroy')->middleware('verified');

Route::post('/profile/addresses', 'App\Http\Controllers\CustomerAddressController@store')->middleware('verified');

Route::post('/profile/addresses/{id}/edit', 'App\Http\Controllers\CustomerAddressController@update')->middleware('verified'); // using traditional form here, doesn't allow put, so using post.

Route::post('/cart', 'App\Http\Controllers\CartItemController@add')->middleware('verified');

Route::post('/product/save', 'App\Http\Controllers\ProductController@addToCartOrWishlist')->middleware('verified');

Route::post('/profile/account/edit', 'App\Http\Controllers\CustomerController@update')->middleware('verified');

Route::get('/cart/{id}/delete', [App\Http\Controllers\CartItemController::class, 'destroy'])->middleware('verified');

Route::post('/subscribers', [App\Http\Controllers\SubscriberController::class, 'store']);

Route::get('/stores/sellers', [App\Http\Controllers\ShopwiseProductController::class, 'fetchStoresForProducts'])->middleware('verified'); // Will be called at runtime from client side script (cart.js).

Route::post('/checkout', [App\Http\Controllers\CartItemController::class, 'checkout'])->middleware('verified');

Route::get('/customerSupport', function() {
    return view('customerSupport');
});

Route::post('/queries', [App\Http\Controllers\QueryController::class, 'store'])->middleware('verified');

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

Route::post('/feedback', [App\Http\Controllers\FeedbackController::class, 'store'])->middleware('verified');

// Routes for the sellers: 

Route::get('/my-stores', [App\Http\Controllers\SellerStoreController::class, 'index'])->middleware('verified');

Route::get('/stores/{id}', [App\Http\Controllers\SellerStoreController::class, 'show'])->middleware('verified');

Route::get('/my-stores/create', [App\Http\Controllers\SellerStoreController::class, 'create'])->middleware('verified');

Route::post('/my-stores', [App\Http\Controllers\SellerStoreController::class, 'store'])->middleware('verified');

Route::get('/my-stores/{id}/edit', [App\Http\Controllers\SellerStoreController::class, 'edit'])->middleware('verified');

Route::put('/my-stores/{id}', [App\Http\Controllers\SellerStoreController::class, 'update'])->middleware('verified');

Route::delete('/my-stores/{id}', [App\Http\Controllers\SellerStoreController::class, 'destroy'])->middleware('verified');


Route::get('/my-stores/{id}/products', [App\Http\Controllers\SellerProductController::class, 'index'])->middleware('verified');

Route::get('/my-stores/{id}/products/create', [App\Http\Controllers\SellerProductController::class, 'create'])->middleware('verified');

Route::post('/my-stores/{id}/products', [App\Http\Controllers\SellerProductController::class, 'store'])->middleware('verified');

Route::get('/products/{id}/json', [App\Http\Controllers\ProductController::class, 'showJson']);

Route::get('/my-stores/{id}/products/{productId}/edit', [App\Http\Controllers\SellerProductController::class,'edit'])->middleware('verified');

Route::put('/my-stores/{id}/products/{productId}', [App\Http\Controllers\SellerProductController::class, 'update'])->middleware('verified');

Route::delete('/my-stores/{id}/products/{productId}', 'App\Http\Controllers\SellerProductController@destroy')->middleware('verified');

Route::get('/delivery-agent/track', function() {
    return view('delivery_agent.gps');
});

Route::post('/delivery-agent/track', function() {
    return redirect('/home');
});

