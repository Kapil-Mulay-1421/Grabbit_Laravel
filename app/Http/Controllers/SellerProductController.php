<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SellerProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $userId = auth()->user()->id;
        // This is a function that queries the database for data about the productss owned by the user and returns the products listing view.
        $productsFromDatabase = DB::table('products')
                ->join('shopwise_products','shopwise_products.product_id','products.product_id')
                ->join('stores','shopwise_products.store_id','stores.store_id')
                ->where('shopwise_products.store_id', '=', $id)
                ->where('owner_customer_id','=',$userId)
                ->get();

        $storeName = DB::table('stores')
                ->where('owner_customer_id', $userId)
                ->where('store_id', $id)
                ->value('store_name');

        return view('seller.showcase', ['products' => $productsFromDatabase, 'heading' => $storeName, 'storeId' => $id]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        //
        $userId = auth()->user()->id;
        $store = DB::table('stores')
                ->where('store_id', $id)
                ->where('owner_customer_id', $userId)
                ->first();
        if(! $store) {
            return redirect('/home')->with('error', 'Invalid Request.');
        }
        $allProductsInDatabase = DB::table('products')
                ->where('unique', null)
                ->orWhere('unique', false)
                ->get();

        $allCategoriesInDatabase = DB::table('categories')
                ->get();

        return view('seller.createProduct', ['products' => $allProductsInDatabase, 'categories' => $allCategoriesInDatabase, 'storeId' => $id]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $userId = auth()->user()->id;
        $store = DB::table('stores')
                ->where('store_id', $id)
                ->where('owner_customer_id', $userId)
                ->first();
        if(! $store) {
            return redirect('/home')->with('error', 'Invalid Request.');
        }

        // not validating image here as the user might just want to sell a pre-existing product
        // in which case they will not upload an image
        $request->validate([
            'quantity' => 'required|integer|min:0', 
            'list_price' => 'required|numeric|min:0', 
        ]);

        if (! $request->input('localproduce')) {
            $localproduce = false;
        } else {
            $localproduce = true;
        }

        if($request->input('productId') != null) {

            $productExists = DB::table('products')
                    ->where('product_id', $request->input('productId'))
                    ->exists();
            if (! $productExists) {
                return redirect('/home')->with('error', 'Invalid Request');
            }

            DB::table('shopwise_products')
                    ->insert([
                        'product_id' => $request->input('productId'), 
                        'store_id' => $store->store_id, 
                        'quantity' => $request->input('quantity'), 
                        'localproduce' => $localproduce, 
                        'list_price' => $request->input('list_price'), 
                        
                    ]);
            return redirect('/my-stores/'.$store->store_id.'/products')->with('success', 'Product successfully added to store.');
        }
        // if product_id in request is null, it means the user is trying to create a new product.
        //validating image
        $request->validate([
            'name' => 'required|max:45', 
            'description' => 'required|max:1023', 
            'category' => 'required', 
            'image' => 'required|image|max:1024', 
        ]);

        // preparing input to store
        $product_name = $request->input('name');
        $product_description = $request->input('description');
        $category_name = $request->input('category');
        $category_id = DB::table('categories')
        ->where('category_name' , '=' , $category_name)
        ->value('category_id');

        if($category_id == null)
        {
            return redirect('/home')->with('error', 'invalid request. Here is the request: '.$request->input('productId'));
        }

        $exactNameExists = DB::table('products')
                ->where('product_name', $product_name)
                ->exists();

        if ($exactNameExists) {
            return redirect('/home')->with('error', 'A product by the same exact name already exists. Please select the product from the products list instead of creating a new one.');
        }
        
        // storing
        $productIdInserted = DB::table('products')->insertGetId([
            'product_name' => $product_name, 
            'description' => $product_description, 
            'category_id' => $category_id, 
            'unique' => true, 
            'owner' => $userId, 
            ]);

        $imagePath = 'images/products/';
        $imageName = $productIdInserted.".".$request->image->extension();
        Storage::disk('public')->putFileAs($imagePath, $request->image, $imageName);

        $url = Storage::url($imagePath.$imageName);

        DB::table('products')
                ->where('product_id', $productIdInserted)
                ->update([
                    'product_image' => $url, 
                ]);

        DB::table('shopwise_products')
        ->insert([
            'product_id' => $productIdInserted, 
            'store_id' => $store->store_id, 
            'quantity' => $request->input('quantity'), 
            'localproduce' => $localproduce, 
            'list_price' => $request->input('list_price'), 
        ]);

        return redirect('/my-stores/'.$store->store_id.'/products')->with('success', 'Product successfully added to store.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, $productId)
    {
        $userId = auth()->user()->id;
        //this is a function that displays the specified resource

        //when product_id is used to view a product
        $productFromDatabase = DB::table('products')
                ->join('shopwise_products','shopwise_products.product_id','products.product_id')
                ->join('stores','shopwise_products.store_id','stores.store_id')
                ->where('stores.store_id', '=', $id)
                ->where('products.product_id', '=', $productId)
                ->where('owner_customer_id','=',$userId)
                ->first();
       return view('seller.product', ['product' => $productFromDatabase]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, $productId)
    {
        $userId = auth()->user()->id;
        $store = DB::table('stores')
                ->where('store_id', $id)
                ->where('owner_customer_id', $userId)
                ->first();
        if(! $store) {
            return redirect('/home')->with('error', 'Invalid Request.');
        }

        $productFromDatabase = DB::table('products')
                ->join('shopwise_products','shopwise_products.product_id','products.product_id')
                ->join('stores','shopwise_products.store_id','stores.store_id')
                ->where('stores.store_id', '=', $id)
                ->where('products.product_id', '=', $productId)
                ->where('owner_customer_id','=',$userId)
                ->first();

        if(! $productFromDatabase) {
            return redirect('/home')->with('error', 'Product does not exist.');
        }

        $product = DB::table('products')
                ->join('shopwise_products','shopwise_products.product_id','products.product_id')
                ->where('shopwise_products.store_id', '=', $id)
                ->where('products.product_id', '=', $productId)
                ->first();

        $allCategoriesInDatabase = DB::table('categories')
                ->get();

        $hasRights = DB::table('products')
                ->where('product_id', $productId)
                ->where('unique', true)
                ->where('owner', $userId)
                ->exists();

       return view('seller.product', ['product' => $product, 'storeName' => $store->store_name, 'storeId' => $id, 'hasRights' => $hasRights, 'categories' => $allCategoriesInDatabase]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, $productId)
    {
        // checking if store is owned by the user
        $userId = auth()->user()->id;
        $store = DB::table('stores')
                ->where('store_id', $id)
                ->where('owner_customer_id', $userId)
                ->first();
        if(! $store) {
            return redirect('/home')->with('error', 'Invalid Request.');
        }

        $product = DB::table('products')
                ->where('product_id', $productId)
                ->first();
        
        if(! $product) {
            return redirect('/home')->with('error', 'Product does not exist.');
        }

        // checking if user has rights to change product info
        $hasRights = DB::table('products')
                ->where('product_id', $productId)
                ->where('unique', true)
                ->where('owner', $userId)
                ->exists();

        if (!$hasRights) {
            // user can only change the quantity and price of the product sold in his store.
            $request->validate([
                'quantity' => 'required|integer|min:0', 
                'list_price' => 'required|numeric|min:0', 
            ]);

            $isSelling = DB::table('shopwise_products')
                    ->where('store_id', $store->store_id)
                    ->where('product_id', $productId)
                    ->exists();
            if (! $isSelling) {
                return redirect('/my-stores/'.$store->store_id.'/products')->with('error', 'Your store does not sell this product. Invalid request.');
            }

            $affected = DB::table('shopwise_products')
                    ->where('store_id', $store->store_id)
                    ->where('product_id', $productId)
                    ->update([
                        'quantity' => $request->input('quantity'), 
                        'list_price' => $request->input('list_price'), 
                    ]);

            if ($affected == 1) {
                return redirect('/my-stores/'.$store->store_id.'/products')->with('success', 'Product info updated.');
                // we know that $productId is genuine since $isSelling is true here
                // which means the productId is Database Verified.
            } else {
                return redirect('/my-stores/'.$store->store_id.'/products')->with('error', 'Something went wrong. Please try again.');
            }
        }

        // if hasRights, the user can change everything about the product.
        $request->validate([
            'name' => 'required|max:45', 
            'description' => 'required|max:1023', 
            'category' => 'required', 
            'quantity' => 'required|integer|min:0', 
            'list_price' => 'required|numeric|min:0', 
            'image' => 'image|max:1024', 
        ]);

        $category_name = $request->input('category');
        $category_id = DB::table('categories')
                ->where('category_name' , '=' , $category_name)
                ->value('category_id');

        if (! $category_id) {
            return redirect('/home')->with('error', 'Invalid Request');
        }

        $affected = DB::table('products')
                ->where('product_id', $productId)
                ->where('unique', true)
                ->where('owner', $userId)
                ->update([
                    'product_name' => $request->input('name'), 
                    'description' => $request->input('description'), 
                    'category_id' => $category_id, 
                ]);

                $affected2 = DB::table('shopwise_products')
                ->where('store_id', $store->store_id)
                ->where('product_id', $productId)
                ->update([
                    'quantity' => $request->input('quantity'), 
                    'list_price' => $request->input('list_price'), 
                ]);

        if($request->image != null) {
            $imagePath = 'images/products/';
            $imageName = $productId.".".$request->image->extension();
            Storage::disk('public')->putFileAs($imagePath, $request->image, $imageName);

            $url = Storage::url($imagePath.$imageName);

            DB::table('products')
                    ->where('product_id', $productId)
                    ->update([
                        'product_image' => $url, 
                    ]);

            return redirect('/my-stores/'.$store->store_id.'/products')->with('success', 'Product info updated.');
        }

        if($request->image == null) {
            return redirect('/my-stores/'.$store->store_id.'/products')->with('success', 'Product info updated.');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,$productId)
    {
        $userId = auth()->user()->id;
        $owner_id = DB::table('stores')
        ->where('store_id', '=' , $id)
        ->value('owner_customer_id');

        if($userId!=$owner_id)
        {
         return redirect('/home')->with('error','Access Denied');
         exit();
        }

        $affected = DB::table('shopwise_products')
        ->where('product_id', '=', $productId)
        ->where('store_id' , '=' , $id)
        ->delete();
        if($affected = 1)
        {
            return redirect('/my-stores/'.$id.'/products')->with('success', 'Deleted product.');
        }
        else
        {
            return redirect('/my-stores/'.$id.'/products')->with('error' , 'invalid request');
        }
    }

}