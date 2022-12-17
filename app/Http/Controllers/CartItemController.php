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

    public function indexJson() {
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

        echo json_encode([$cartItems, $total, $subtotal, $appliedCoupon]);
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
        return redirect('/home')->with('success', 'Added item to cart.');
    }

    public function destroy($id) {
        $userId = auth()->user()->id;
        $affected = DB::table('cart_items')
                ->where('id', $id)
                ->where('customer_id', $userId)
                ->delete();

        if($affected == 1) {
            return redirect('/cart')->with('success', 'Product removed.');
        } else {
            return redirect('/cart')->with('error', 'Something went wrong, please try again.');
        }
    }

    public function checkout(Request $request) {

        $userId = auth()->user()->id;

        $cartItems = $request->input('cartItems');
        $cartItems = json_decode($cartItems);

        function validateCart($cartItems) {

            $shouldBeNums = ['current_list_price', 'id', 'product_id', 'quantity', 'store_id'];
            $shouldBeStrs = ['product_image', 'product_name'];
    
            if (! gettype($cartItems) == "array") {
                return false;
            }
    
            foreach($cartItems as $cartItem) {
    
                if (! gettype($cartItem) == "object") {
                    return false;
                }
                foreach($shouldBeNums as $attribute) {
                    if (! is_numeric($cartItem -> $attribute)) {
                        return false;
                    }
                }
                foreach($shouldBeStrs as $attribute) {
                    if (! is_string($cartItem -> $attribute)) {
                        return false;
                    }
                }
    
                // Now validating from database perspective:
                foreach($cartItems as $cartItem) {
                    $itemExists = DB::table('shopwise_products')
                            ->where('product_id', $cartItem->product_id)
                            ->where('store_id', $cartItem->store_id)
                            ->where('quantity', '>=', $cartItem->quantity)
                            ->exists();
                    if(! $itemExists) {
                        return false;
                    }
                }
            }
            return true;
        }

        $cartIsValid = validateCart($cartItems);
        if (! $cartIsValid) {
            return redirect('/cart')->with("error", "Something went wrong. Please try again.");
        }

        // Proceeds only when cart is valid. First deleting the current cartItems, then adding the new cartItems.
        $deleted = DB::table('cart_items')
                ->where('customer_id', $userId)
                ->delete();
        foreach($cartItems as $cartItem) {
            DB::table('cart_items')
                    ->insert(['customer_id' => $userId, 'product_id' => $cartItem->product_id, 'store_id' => $cartItem->store_id, 'quantity' => $cartItem->quantity]);
        }
        if ($deleted == count($cartItems)) {
            return view('checkout');
        }
    }
}
