<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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

        return view('showcase', ['products'=>$deals, 'heading' => 'Best Deals']);
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
                ->select(DB::raw('products.product_id, min(store_id) as store_id, product_name, description, list_price, product_image, category_id'))
                ->where('product_name', $productName)
                // ->where('list_price', '=', $minListPrice[0]->list_price) // isn't working, returns 0 rows. $minListPrice[0]->list_price is correct.
                ->groupBy('list_price')
                ->groupBy('products.product_id')
                ->get();
        
        // delete the below loop once the above problem is fixed.
        foreach($response as $item) {
            if ($item->list_price == $minListPrice[0]->list_price) {
                $product = $item;
            }
        }

        // $product = $response[0];

        // Checking if product is in wishlist
        if(Auth::check()) {
                $userId = auth()->user()->id;
                $inWishlist = DB::table('wishlist_items')
                        ->where('product_id', '=', $product->product_id)->where('customer_id', $userId)->exists(); // returns bool
        } else {
                $inWishlist = false;
        }

        return view('product', ['product'=>$product, 'inWishlist'=>$inWishlist]);
    }

    public function showJson($id) {
        $product = DB::table('products')
                        ->where('product_id', $id)
                        ->first();

        return json_encode($product);
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

        return view('showcase', ['products'=>$products, 'heading' => 'Local Produce']);
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

        return view('showcase', ['products'=>$productsk, $heading => 'Fresh Finds']);
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

        return view('showcase', ['products'=>$products, 'heading' => 'Most Popular']);
    }

    // More functions related to other tables...

    public function addToCartOrWishlist(Request $request) {
        if (isset($_POST['addToCart'])) {
                function addToCart(Request $request) {
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

                addToCart($request);
                return back()->with('success', 'Added item to cart.');


        } else {
                function addToWishlist(Request $request) {
                        $productId = $request->input('productId');
                        $storeId = $request->input('storeId');
                        $quantity = $request->input('quantity');

                        $alreadyInWishlist = DB::table('wishlist_items')
                                ->where('product_id', $productId)
                                ->exists();
                        if ($alreadyInWishlist) {
                            // user wants to delete from wishlist.
                            DB::table('wishlist_items')
                                    ->where('product_id', $productId)
                                    ->delete();

                            return ['status' => 'Deleted item from wishlist.'];
                        }
                
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
                            return ['status' => 'Added item to wishlist.'];
                        }
                    }

                $res = addToWishlist($request);
                return back()->with('success', $res['status']);
        }
    }

    public function handleSearch(Request $request) {
        $search = $request->input('search');
        $percentSign = '%';
        $queryConcat = $percentSign."".$search."".$percentSign;
        $allProducts = DB::table('shopwise_products')
        ->join('products', 'shopwise_products.product_id', '=', 'products.product_id')
        ->join('stores', 'shopwise_products.store_id', '=', 'stores.store_id')
        ->join('categories', 'categories.category_id', 'products.category_id')
        ->where('quantity', '>', 0)
        ->where('product_name', 'like', $queryConcat)
        ->orWhere('category_name', 'like', $queryConcat)
        ->orderBy('products.product_id')
        ->orderBy('shopwise_products.list_price')
        ->get();

        // Getting unique shop products with lowest price for the "Best Deals" showcase.
        $uniqueIds = [];
        $products = [];
        foreach($allProducts as $product) {
                if(! in_array($product->product_id, $uniqueIds)) {
                        array_push($products, $product);
                        array_push($uniqueIds, $product->product_id);
                }
        }

        return view('showcase', ['products'=>$products, 'heading' => 'Search Results']);
    }
}
