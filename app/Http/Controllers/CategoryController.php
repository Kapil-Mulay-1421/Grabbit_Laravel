<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    //

    public function show($category) {

        // Checking if category is valid
        $categoryExists = DB::table('categories')
                ->where('category_name', $category)
                ->exists();

        if (! $categoryExists) {
            // Case of URL Manipulation
            return redirect('/home')->with('error', 'Could not find the requested category. Please try one of the categoies listed in our product range.');
        }

        // After getting a category id from the url, we display the products from the category
        $allProducts = DB::table('shopwise_products')
        ->join('products', 'shopwise_products.product_id', '=', 'products.product_id')
        ->join('stores', 'shopwise_products.store_id', '=', 'stores.store_id')
        ->join('categories', 'products.category_id', '=', 'categories.category_id')
        ->where('quantity', '>', 0)
        ->where('category_name', $category)
        ->orderBy('products.product_id')
        ->orderBy('shopwise_products.list_price')
        ->get();

        // Getting unique shop products with lowest price for the given category.
        $uniqueIds = [];
        $products = [];
        foreach($allProducts as $product) {
            if(! in_array($product->product_id, $uniqueIds)) {
                array_push($products, $product);
                array_push($uniqueIds, $product->product_id);
            }
        }

        return view('showcase', ['products' => $products, 'heading' => $category]);
    }
}
