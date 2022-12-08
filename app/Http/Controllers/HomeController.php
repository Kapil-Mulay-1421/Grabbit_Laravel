<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ShopwiseProduct;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $allProducts = DB::table('shopwise_products')
                ->join('products', 'shopwise_products.product_id', '=', 'products.product_id')
                ->join('stores', 'shopwise_products.store_id', '=', 'stores.store_id')
                ->where('quantity', '>', 0)
                ->orderBy('products.product_id')
                ->orderBy('shopwise_products.list_price')
                ->get();

        // Getting unique shop products with lowest price for the "Best Deals" showcase.
        $uniqueIds = [];
        $deals = [];
        foreach($allProducts as $product) {
            if(! in_array($product->product_id, $uniqueIds)) {
                array_push($deals, $product);
                array_push($uniqueIds, $product->product_id);
            }
        }

        // Filtering deals for the "Start Your Cart" showcase.
        $startYourCartCategories = array(2, 4, 8, 10, 12, 14, 17);
        $startYourCartProducts = [];
        foreach($deals as $product) {
            if (in_array($product->category_id, $startYourCartCategories)) {
                array_push($startYourCartProducts, $product);
            }
        }

        // Fetching the most popular products for the "Most Popular" showcase.
        // Fetching ids from oder_items:
        $popularProducts = DB::table('order_items')
                    ->select(DB::raw('product_id, count(*) as freq'))
                    ->groupBy('product_id')
                    ->orderBy('freq', 'DESC')
                    ->limit(20)
                    ->get();
        $popularProductIds = [];
        foreach($popularProducts as $product) {
            array_push($popularProductIds, $product->product_id);
        }
        // Fetching cheapest deals on the most popular product_ids:
        $mostPopularProducts = [];
        foreach($deals as $product) {
            if (in_array($product->product_id, $popularProductIds)) {
                array_push($mostPopularProducts, $product);
            }
        }

        // Filtering deals for the "Fresh Finds" showcase.
        $freshFindsCategories = array(1, 10);
        $freshFindsProducts = [];
        foreach($deals as $product) {
            if(in_array($product->category_id, $freshFindsCategories)) {
                array_push($freshFindsProducts, $product);
            }
        }

        return view('home', ['deals' => $deals, 
                            'startYourCartProducts' => $startYourCartProducts, 
                            'mostPopularProducts' => $mostPopularProducts, 
                            'freshFindsProducts' => $freshFindsProducts]);
    }
}
