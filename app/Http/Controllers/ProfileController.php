<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{

    //

    public function index($tab) {

        $userId = auth()->user()->id;

        function getWishlistItems($userId) {
            $userId = auth()->user()->id;
            $wishlistItems = DB::table('wishlist_items')
                    ->select('products.product_id', 'products.product_name', 's.list_price', 'wishlist_items.quantity', 'products.product_image', 's.localproduce')
                    ->leftJoin('products', 'products.product_id', 'wishlist_items.product_id')
                    ->leftJoin('shopwise_products as s', 's.product_id', 'wishlist_items.product_id')
                    ->whereRaw('s.store_id = wishlist_items.store_id')
                    ->where('customer_id', $userId)
                    ->get();

            return $wishlistItems;
        }

        function getOrders($userId) {
            $orders = DB::table('order_items')
                    ->join('orders', 'orders.order_id', 'order_items.order_id')
                    ->join('products', 'products.product_id', 'order_items.product_id')
                    ->join('stores', 'stores.store_id', 'order_items.store_id')
                    ->where('orders.customer_id', $userId)
                    ->get();
            return $orders;
        }

        function getAllAddresses($userId) {
            $allAddresses = DB::table('customer_addresses')
                    ->where('customer_id', $userId)
                    ->get();

            return $allAddresses;
        }

        function getActiveAddress($userId) {
            $activeAddressId = DB::table('customers')
                    ->where('customer_id', $userId)
                    ->value('active_address');
            $activeAddress = DB::table('customer_addresses')
                    ->where('address_id', $activeAddressId)
                    ->get();
            return $activeAddress[0]; // There is only one record, the 0th element of activeAddresses.
        }

        function getCustomer($userId) {
            $customer = DB::table('customers')
                    ->select('first_name', 'last_name', 'email', 'phone')
                    ->where('customer_id', $userId)
                    ->first();
            return $customer;
        }

        switch ($tab) {
            
            case 'wishlist':
                $wishlist = getWishlistItems($userId);
                return view('profile.wishlist', ['wishlist'=>$wishlist]);
            case 'orders':
                $orders = getOrders($userId);
                return view('profile.orders', ['orders'=>$orders]);
            case 'addresses':
                $allAddresses = getAllAddresses($userId);
                $activeAddress = getActiveAddress($userId);
                return view('profile.addresses', ['allAddresses'=>$allAddresses, 'activeAddress'=>$activeAddress]);
            case 'subscriptions':
                return view('profile.subscriptions');
            case 'wallet':
                return view('profile.wallet');
            case 'account':
                $customer = getCustomer($userId);
                return view('profile.account', ['customer' => $customer]);
            default:
                return redirect()->route('home');
        }
    }

}