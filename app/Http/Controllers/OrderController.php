<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Events\PaymentReceived;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    //

    public function index() {
        $userId = auth()->user()->id;
        $orders = DB::table('orders')
                ->where('customer_id', $userId)
                ->get();

        return view('orders', ['orders' => $orders]);
    }

    public function verifyAndCreateOrder(Request $request) {        

        $success = true;

        $error = "Payment Failed";

        $razorpayOrder = session('razorpayOrder');

        if (empty($_POST['razorpay_payment_id']) === false)
        {
            $keyId = "rzp_test_s5yDUHGWsYmtrg";
            $secret = "1E5E2FuGI6dQ7iJc4u4hsjNM";
            $api = new Api($keyId, $secret);

            try
            {
                // Please note that the razorpay order ID must
                // come from a trusted source (session here, but
                // could be database or something else)
                $attributes = array(
                    'razorpay_order_id' => $razorpayOrder->id,
                    'razorpay_payment_id' => $request->input('razorpay_payment_id'),
                    'razorpay_signature' => $request->input('razorpay_signature')
                );

                $api->utility->verifyPaymentSignature($attributes);
            }
            catch(SignatureVerificationError $e)
            {
                $success = false;
                $error = 'Razorpay Error : ' . $e->getMessage();
            }
        }

        if ($success === true)
        {
            $userId = auth()->user()->id;
            $totalAmount = $razorpayOrder->amount;
            $totalAmount = $totalAmount/100;
            $subtotal = session('subtotal');
            $referenceId = $request->input('razorpay_payment_id'); // since we know that the payment source is authentic.
            $note = session('note');
            $date = date('Y-m-d');
            $status = 1;
            $shipping = 33;

            $address = session('address');
            $activeAddress = $address->address. ", ".$address->city. ", ".$address->state.", ".$address->country;

            $orderAlreadyAdded = DB::table('orders')
                    ->where('reference_id', $referenceId)
                    ->exists();

            if($orderAlreadyAdded) {
                return redirect('/home')->with('success', 'Your order has been recorded.');
                exit();
            }

            $orderId = DB::table('orders')
                        ->insertGetId(['reference_id' => $referenceId, 'customer_id' => $userId, 'subtotal' => $subtotal, 'total_amount' => $totalAmount, 'order_date' => $date, 'order_status' => $status, 'billing_address' => $activeAddress, 'shipping_address' => $activeAddress, 'payment_method' => 'razorpay', 'note' => $note, 'shipping' => $shipping]);

            $cartItems = session('cartItems');

            foreach($cartItems as $cartItem) {
                DB::table('order_items')
                        ->insert(['order_id' => $orderId, 'product_id' => $cartItem->product_id, 'store_id' => $cartItem->store_id, 'quantity' => $cartItem->quantity, 'buy_price' =>$cartItem->current_list_price, 'discount' => '0' ]);
                
                DB::table('shopwise_products')
                        ->where('product_id', $cartItem->product_id)
                        ->where('store_id', $cartItem->store_id)
                        ->decrement('quantity', $cartItem->quantity);
            }

            $order = DB::table('orders')
                    ->where('order_id', $orderId)
                    ->first();

            $orderItems = DB::table('order_items')
                            ->join('stores', 'stores.store_id', 'order_items.store_id')
                            ->join('products', 'products.product_id', 'order_items.product_id')
                            ->where('order_id', $order->order_id)
                            ->get();

            // Send email to customer, etc.
            $customerDetails = DB::table('customers')
                    ->where('customer_id', $userId)
                    ->first();
            try {
                PaymentReceived::dispatch($order, $orderItems, 'Stripe', $customerDetails->email);
            } catch(\Exception $e) {
                Log::error($e);
            }

            $fullName = $customerDetails->first_name." ".$customerDetails->last_name;

            return view('paymentSuccess', ['customerName' => $fullName]);
        }
        else
        {
            return view('paymentFailure', ['error' => $error]);
        }

    }

    public function show($id) {

        $userId = auth()->user()->id;
        $orderItems = DB::table('order_items') 
                ->join('orders', 'orders.order_id', 'order_items.order_id')
                ->join('products', 'products.product_id', 'order_items.product_id')
                ->join('stores', 'stores.store_id', 'order_items.store_id')
                ->where('order_items.order_id', $id)
                ->where('customer_id', $userId)
                ->get();

        $order = DB::table('orders')
                ->where('order_id', $id)
                ->first();

        $customerDetails = DB::table('customers')
                ->where('customer_id', $userId)
                ->first();
        $fullName = $customerDetails->first_name." ".$customerDetails->last_name;

        return view('profile.order', ['orderItems' => $orderItems, 'order' => $order, 'customerName' => $fullName]);
    }

    public function handlePaymentSuccess(Request $request) {
        $stripeSecretKey = env('STRIPE_SECRET_TEST_KEY');
        \Stripe\Stripe::setApiKey($stripeSecretKey);
        $userId = auth()->user()->id;


        $sessionId = $request->get('session_id');

        try {
            $session = \Stripe\Checkout\Session::retrieve($sessionId);
            
            if(!$session) {
                throw new NotFoundHttpException;
                echo "session invalid";
            }

            $order = DB::table('orders') 
                    ->where('stripe_session_id', $session->id)
                    ->where('customer_id', $userId)
                    ->first();
            if(!$order) {
                throw new NotFoundHttpException;
            }

            $customerDetails = DB::table('customers')
                    ->where('customer_id', $userId)
                    ->first();
            $fullName = $customerDetails->first_name." ".$customerDetails->last_name;

            return view('paymentSuccess', ['customerName' => $fullName]);

        } catch(\Exception $e) {

            throw new NotFoundHttpException;

        }
    }

    public function webhook() {
        // This is your Stripe CLI webhook secret for testing your endpoint locally.
        $endpoint_secret = env('STRIPE_WEBHOOK_SECRET');
        $stripeSecretKey = env('STRIPE_SECRET_TEST_KEY');
        \Stripe\Stripe::setApiKey($stripeSecretKey);

        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $event = null;

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload, $sig_header, $endpoint_secret
            );
        } catch (\UnexpectedValueException $e) {
            // Invalid payload
            return response('', 400);
            exit();
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            return response('', 400);
            exit();
        }

        // Handle the event
        switch ($event->type) {
            case 'checkout.session.completed':
                $session = $event->data->object;

                $order = DB::table('orders')
                        ->where('stripe_session_id', $session->id)->first();
                if ($order && $order->order_status == 0) {
                    DB::table('orders')
                            ->where('stripe_session_id', $session->id)
                            ->update(['order_status' => 1]);
                    $orderItems = DB::table('order_items')
                            ->join('stores', 'stores.store_id', 'order_items.store_id')
                            ->join('products', 'products.product_id', 'order_items.product_id')
                            ->where('order_id', $order->order_id)
                            ->get();
                    
                    foreach($orderItems as $orderItem) {
                        DB::table('shopwise_products')
                                ->where('product_id', $orderItem->product_id)
                                ->where('store_id', $orderItem->store_id)
                                ->decrement('quantity', $orderItem->quantity);
                    }
                    // updating order as we just changed the order_status;
                    $order = DB::table('orders')
                        ->where('stripe_session_id', $session->id)->first();

                    // Send email to customer, etc.
                    $customerEmail = $session->customer_details->email;
                    try {
                        PaymentReceived::dispatch($order, $orderItems, 'Stripe', $customerEmail);
                    } catch(\Exception $e) {
                        Log::error($e);
                    }
                }

            // ... handle other event types
            default:
                echo 'Received unknown event type ' . $event->type;
        }

        return response('', 200);
    }
}
