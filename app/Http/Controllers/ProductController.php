<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    //

    public function index() {
        // This function returns best deals

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

        return view('showcase', ['products'=>$deals]);
    }

    public function show($productName) {
        // This function returns the information of the asked product
        $minListPrice = DB::table('shopwise_products')
                ->join('products', 'products.product_id', 'shopwise_products.product_id')
                ->select(DB::raw('min(list_price) as list_price'))
                ->where('product_name', $productName)
                ->get();
                
        $response = DB::table('shopwise_products') // response is an array containing only one item.
                ->join('products', 'products.product_id', 'shopwise_products.product_id')
                ->select(DB::raw('products.product_id, min(store_id) as store_id, product_name, list_price, product_image, category_id'))
                ->where('product_name', $productName)
                ->where('list_price', '=', $minListPrice[0]->list_price)
                ->groupBy('list_price')
                ->groupBy('products.product_id')
                ->get();
        $product = $response[0];

        // Checking if product is in wishlist
        $inWishlist = DB::table('wishlist')
                ->where('id', $product->product_id)->exists(); // returns bool

        return view('product', ['product'=>$product, 'inWishlist'->$inWishlist]);
    }

    public function localproduce() {
        $allLocalProducts = DB::table('shopwise_products')
        ->join('products', 'shopwise_products.product_id', '=', 'products.product_id')
        ->join('stores', 'shopwise_products.store_id', '=', 'stores.store_id')
        ->where('quantity', '>', 0)
        ->where('localproduce', true)
        ->orderBy('products.product_id')
        ->orderBy('shopwise_products.list_price')
        ->get();

        // Getting unique shop products with lowest price.
        $uniqueIds = [];
        $products = [];
        foreach($allLocalProducts as $product) {
                if(! in_array($product->product_id, $uniqueIds)) {
                        array_push($products, $product);
                        array_push($uniqueIds, $product->product_id);
                }
        }

        return view('showcase', ['products'=>$products]);
    }

    public function freshFinds() {
        $freshFindsCategories = array(1, 10);
        $allFreshFindsProducts = DB::table('shopwise_products')
        ->join('products', 'shopwise_products.product_id', '=', 'products.product_id')
        ->join('stores', 'shopwise_products.store_id', '=', 'stores.store_id')
        ->where('quantity', '>', 0)
        ->whereIn('category_name', $freshFindsCategories)
        ->orderBy('products.product_id')
        ->orderBy('shopwise_products.list_price')
        ->get();

        // Getting unique shop products with lowest price.
        $uniqueIds = [];
        $products = [];
        foreach($allFreshFindsProducts as $product) {
                if(! in_array($product->product_id, $uniqueIds)) {
                        array_push($products, $product);
                        array_push($uniqueIds, $product->product_id);
                }
        }

        return view('showcase', ['products'=>$products]);
    }

    public function mostPopular() {
        // Fetching the most popular products for the "Most Popular" showcase.
        // Fetching ids from oder_items:
        $popularProducts = DB::table('order_items')
                    ->select(DB::raw('product_id, count(*) as freq'))
                    ->groupBy('product_id')
                    ->orderBy('freq', 'DESC')
                    ->limit(20)
                    ->get();
        $products = [];
        foreach($popularProducts as $popularProduct) {
                $response = DB::table('shopwise_products') // response is an array containing only one item.
                ->join('products', 'products.product_id', 'shopwise_products.product_id')
                ->select(DB::raw('products.product_id, min(store_id) as store_id, product_name, list_price, product_image, category_id'))
                ->where('product_id', $popularProduct->product_id)
                ->where('list_price', '=', $minListPrice[0]->list_price)
                ->groupBy('list_price')
                ->groupBy('products.product_id')
                ->get();
            array_push($products, $response[0]);
        }

        return view('showcase', ['products'=>$products]);
    }
}
