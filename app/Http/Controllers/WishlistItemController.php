<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistItemController extends Controller
{
    //

    public function index() {
        $userId = auth()->user()->id;
        $wishlistItems = DB::table('wishlist_items')
                ->join('products', 'products.product_id', 'wishlist_items.product_id')
                ->where('customer_id', $userId)
                ->get();
        // Getting current list prices for all the products in the wishlist.
        foreach($wishlistItems as $item) {
            $productId = $item->product_id;
            $storeId = $item->store_id;

            $currentListPrice = DB::table('shopwise_products')
                    ->where('store_id', $storeId)
                    ->where('product_id', $productId)
                    ->value('list_price');
            $item->current_list_price = $currentListPrice;
        }

        return view('profile.wishlist', ['wishlist' => $wishlistItems]);
    }

    public function add() {
        $productId = $request->input('productId');
        $storeId = $request->input('storeId');
        $quantity = $request->input('quantity');

        // Checking if product actually exists.
        $exists = DB::table('shopwise_products')
                ->where('store_id', $storeId)
                ->where('product_id', $productId)
                ->exists();
        if ($exists) {
            $userId = auth()->user()->id;
            DB::table('wishlist_items')
                    ->updateOrInsert(
                        ['customer_id'=>$userId, 'store_id'=>$storeId, 'product_id'=>$productId], 
                        ['quantity'=>$quantity]
                    );
        }
        return back()->with('success', 'Added item to wishlist.');
    }
}
