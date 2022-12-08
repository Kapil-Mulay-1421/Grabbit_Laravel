<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartItemController extends Controller
{
    //

    public function index() {
        $userId = auth()->user()->id;
        $cartItems = DB::table('cart_items')
                ->join('products', 'products.product_id', 'cart_items.product_id')
                ->where('customer_id', $userId)
                ->get();
        // Getting current list prices for all the products in the cart.
        foreach($cartItems as $item) {
            $productId = $item->product_id;
            $storeId = $item->store_id;

            $currentListPrice = DB::table('shopwise_products')
                    ->where('store_id', $storeId)
                    ->where('product_id', $productId)
                    ->value('list_price');
            $item->current_list_price = $currentListPrice;
        }

        $twentyPercentCouponApplies = DB::table('customers')
                ->where('customer_id', $userId)
                ->where('subscribed', true)
                ->where('sub_token_used', false)
                ->exists();

        // Finding subtotal and total
        $subtotal = 0;
        foreach($cartItems as $cartItem) {
            $subtotal += $cartItem->current_list_price * $cartItem->quantity;
        }
        if ($twentyPercentCouponApplies) {
            $total = $subtotal*80/100;
            $appliedCoupon = true;
        } else {
            $total = $subtotal;
            $appliedCoupon = false;
        }

        return view('cart', ['cartItems'=>$cartItems, 'total'=>$total, 'subtotal'=>$subtotal, 'appliedCoupon'=>$appliedCoupon]);
    }

    public function add(Request $request) {
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
            DB::table('cart_items')
                    ->updateOrInsert(
                        ['customer_id'=>$userId, 'store_id'=>$storeId, 'product_id'=>$productId], 
                        ['quantity'=>$quantity]
                    );
        }
    }

    public function delete(Request $request) {
        $userId = auth()->user()->id;
        DB::table('cart_items')
                ->where('id', $id)
                ->where('customer_id', $userId)
                ->delete();
    }
}
