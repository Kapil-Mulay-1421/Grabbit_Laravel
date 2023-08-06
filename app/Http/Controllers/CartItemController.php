<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;

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

        $twentyPercentCouponApplies = false;
        $shipping = 33.00;
        // Uncomment the following code to bring back the twenty percent off coupons on first signup.
        /*
        $twentyPercentCouponApplies = DB::table('customers')
        ->where('customer_id', $userId)
        ->where('subscribed', true)
        ->where('sub_token_used', false)
        ->exists();
        */
        // Finding subtotal and total
        $subtotal = 0;
        foreach($cartItems as $cartItem) {
            $subtotal += $cartItem->current_list_price * $cartItem->quantity;
        }
        if ($twentyPercentCouponApplies) {
            $total = $subtotal*80/100 + $shipping;
            $appliedCoupon = true;
        } else {
            $total = $subtotal+$shipping;
            $appliedCoupon = false;
        }

        function getActiveAddress($userId) {
            $activeAddress = null;
            $activeAddressId = DB::table('customers')
                    ->where('customer_id', $userId)
                    ->value('active_address');
            if (!$activeAddressId) {
                return null;
            }
            $activeAddress = DB::table('customer_addresses')
                    ->where('address_id', $activeAddressId)
                    ->first();
            if (!$activeAddress) {
                return null;
            }
            return $activeAddress;
        }

        $activeAddress = getActiveAddress($userId);
        $addressFound = true;
        if($activeAddress == null) {
            $addressFound = false;
        }

        return view('cart', ['cartItems'=>$cartItems, 'total'=>$total, 'subtotal'=>$subtotal, 'appliedCoupon'=>$appliedCoupon, 'addressFound' => $addressFound, 'address' => $activeAddress, 'shipping' => $shipping]);
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

        $twentyPercentCouponApplies = false;
        $shipping = 33.00;
            // Uncomment the following code to bring back the twenty percent off coupons on first signup.
            /*
            $twentyPercentCouponApplies = DB::table('customers')
            ->where('customer_id', $userId)
            ->where('subscribed', true)
            ->where('sub_token_used', false)
            ->exists();
            */

        // Finding subtotal and total
        $subtotal = 0;
        foreach($cartItems as $cartItem) {
            $subtotal += $cartItem->current_list_price * $cartItem->quantity;
        }
        if ($twentyPercentCouponApplies) {
            $total = $subtotal*80/100 + $shipping;
            $appliedCoupon = true;
        } else {
            $total = $subtotal+$shipping;
            $appliedCoupon = false;
        }

        echo json_encode([$cartItems, $total, $subtotal, $appliedCoupon, $shipping]);
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
        if ((floor($quantity)==$quantity) && $quantity >= 1) {
            $validQuantity = true;
        } else {
            $validQuantity = false;
        }

        if ($exists && $validQuantity) {
            $userId = auth()->user()->id;
            DB::table('cart_items')
                    ->updateOrInsert(
                        ['customer_id'=>$userId, 'store_id'=>$storeId, 'product_id'=>$productId], 
                        ['quantity'=>$quantity]
                    );
            return back()->with('success', 'Added item to cart.');
        } else {
            return back()->with('error', 'Invalid product or Quantity.');
        }
    }

    public function addAllFromWishlist(Request $request) {
        $userId = auth()->user()->id;
        $wishlistItems = DB::table('wishlist_items')
                ->where('customer_id', $userId)
                ->get();
        foreach($wishlistItems as $wishlistItem) {
            $productId = $wishlistItem->product_id;
            $storeId = $wishlistItem->store_id;
            $quantity = 1;
            DB::table('cart_items')
                    ->updateOrInsert(
                        ['customer_id'=>$userId, 'store_id'=>$storeId, 'product_id'=>$productId], 
                        ['quantity'=>$quantity]
                    );

            DB::table('wishlist_items')
                    ->where('customer_id', $userId)
                    ->where('product_id', $productId)
                    ->where('store_id', $storeId)
                    ->delete();
        }
        return back()->with('success', 'All items from wishlist transferred to cart.');
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

        $note = $request->input('orderNote');
        $paymentPreference = $request->input('paymentPreference');

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

        function getActiveAddress($userId) {
            $activeAddress = null;
            $activeAddressId = DB::table('customers')
                    ->where('customer_id', $userId)
                    ->value('active_address');
            if (!$activeAddressId) {
                return null;
            }
            $activeAddress = DB::table('customer_addresses')
                    ->where('address_id', $activeAddressId)
                    ->first();
            if (!$activeAddress) {
                return null;
            }
            return $activeAddress;
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

            // Calculating final total

            $twentyPercentCouponApplies = false;
            $shipping = 33.00;
            // Uncomment the following code to bring back the twenty percent off coupons on first signup.
            /*
            $twentyPercentCouponApplies = DB::table('customers')
            ->where('customer_id', $userId)
            ->where('subscribed', true)
            ->where('sub_token_used', false)
            ->exists();
            */

            // Finding subtotal and total
            $subtotal = 0;
            foreach($cartItems as $cartItem) {
                $subtotal += $cartItem->current_list_price * $cartItem->quantity;
            }
            if ($twentyPercentCouponApplies) {
                $total = $subtotal*80/100 + $shipping;
                $appliedCoupon = true;
            } else {
                $total = $subtotal+$shipping;
                $appliedCoupon = false;
            }

            switch($paymentPreference) {
                case 'razorpay': 

                    // Razorpay is currently unavailable as they need specific payment details in place.
                    // Use the below code once we have the access to the API keys.

                    /*
                    $address = getActiveAddress($userId);
                    if ($address == null) {
                        return redirect('/profile/addresses')->with('error', 'Please activate an address before checkout.');
                    }

                    session(['address' => $address]);

                    $keyId = "rzp_test_s5yDUHGWsYmtrg";
                    $secret = env("RAZORPAY_SECRET_TEST_KEY");
                    $api = new Api($keyId, $secret);
        
                    $razorpayOrder = $api->order->create(array('amount' => ceil($total*100), 'currency' => 'INR'));
                    session(['razorpayOrder' => $razorpayOrder]);
                    session(['cartItems' => $cartItems]);
                    session(['subtotal' => $subtotal, 'total' => $total, 'note' => $note]);

                    return view('checkout', ['total' => ceil($total*100), 'razorpay_order_id' => $razorpayOrder->id]);
                    break;
                    */
                    return redirect('/cart')->with('error', 'Please choose a valid payment method.');

                case 'stripe': 
                    // adding cart items to session: 
                    session(['cartItems' => $cartItems]);
                    session(['subtotal' => $subtotal, 'total' => $total, 'note' => $note]);                    

                    $stripeSecretKey = env('STRIPE_SECRET_TEST_KEY');
                    \Stripe\Stripe::setApiKey($stripeSecretKey);
                    $YOUR_DOMAIN = 'http://localhost:8000';

                    // For discounts, check https://stripe.com/docs/payments/checkout/discounts

                    //creating a line_items array for Stripe checkout session
                    $lineItems = [];
                    foreach($cartItems as $cartItem) {
                        $lineItem = [
                            'price_data' => [
                              'currency' => 'inr',
                              'unit_amount' => $cartItem->current_list_price*100, // unit_amount must be in paise.
                              'product_data' => [
                                'name' => $cartItem->product_name,
                              ],
                            ],
                            'quantity' => $cartItem->quantity,
                        ];
                        array_push($lineItems, $lineItem);
                    }

                    // creating order:

                    $date = date('Y-m-d');
                    $status = 0; // payment status not paid
                    $address = getActiveAddress($userId);
                    if ($address == null) {
                        return redirect('/profile/addresses')->with('error', 'Please activate an address before checkout.');
                    }
                    $activeAddress = $address->address. ", ".$address->city. ", ".$address->state.", ".$address->country;
            
                    $orderId = DB::table('orders')
                            ->insertGetId(['reference_id' => null, 'customer_id' => $userId, 'subtotal' => $subtotal, 'total_amount' => $total, 'order_date' => $date, 'order_status' => $status, 'billing_address' => $activeAddress, 'shipping_address' => $activeAddress, 'payment_method' => 'stripe', 'note' => $note, 'stripe_session_id' => null, 'shipping' => $shipping]); // As of now, only payments from stripe are redirected to this function. May change in the future.
                                
                    foreach($cartItems as $cartItem) {
                        DB::table('order_items')
                                ->insert(['order_id' => $orderId, 'product_id' => $cartItem->product_id, 'store_id' => $cartItem->store_id, 'quantity' => $cartItem->quantity, 'buy_price' =>$cartItem->current_list_price, 'discount' => '0' ]);
                    }

                    $checkout_session = \Stripe\Checkout\Session::create([
                        'shipping_options' => [
                            [
                              'shipping_rate_data' => [
                                'type' => 'fixed_amount',
                                'fixed_amount' => ['amount' => 3300, 'currency' => 'inr'],
                                'display_name' => 'Shipping',
                              ],
                            ],
                          ],
                        'line_items' => $lineItems,
                        'mode' => 'payment',
                        'success_url' => $YOUR_DOMAIN . '/stripe-success?session_id={CHECKOUT_SESSION_ID}',
                        'cancel_url' => $YOUR_DOMAIN . '/cart',
                        'client_reference_id' => $orderId,
                      ]);

                    DB::table('orders')
                        ->where('order_id', $orderId)
                        ->update(['stripe_session_id' => $checkout_session->id]);
                      
                    return redirect($checkout_session->url);
            }

        }
    }

}
