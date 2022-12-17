<?php

namespace App\Http\Controllers;

use App\Models\ShopwiseProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShopwiseProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ShopwiseProduct  $shopwiseProduct
     * @return \Illuminate\Http\Response
     */
    public function show(ShopwiseProduct $shopwiseProduct)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ShopwiseProduct  $shopwiseProduct
     * @return \Illuminate\Http\Response
     */
    public function edit(ShopwiseProduct $shopwiseProduct)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ShopwiseProduct  $shopwiseProduct
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ShopwiseProduct $shopwiseProduct)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ShopwiseProduct  $shopwiseProduct
     * @return \Illuminate\Http\Response
     */
    public function destroy(ShopwiseProduct $shopwiseProduct)
    {
        //
    }

    public function fetchStoresForProducts(Request $request) {
        $userId = auth()->user()->id;
        // Getting productIds from user cart.
        $productIds = DB::table('cart_items')
                ->where('customer_id', $userId)
                ->pluck('product_id');
        $storeInfosLists = array();
        $storeIdsLists = array();
        $i = 0;
        foreach ($productIds as $productId) {
            array_push($storeInfosLists, []);
            array_push($storeIdsLists, []);
            $sellers = DB::table('shopwise_products')
                    ->leftJoin('stores', 'stores.store_id', 'shopwise_products.store_id')
                    ->where('product_id', $productId)
                    ->get();

            foreach($sellers as $seller) {
                array_push($storeIdsLists[$i], $seller->store_id);
                array_push($storeInfosLists[$i], [$seller->store_name, $seller->quantity, $seller->list_price, $seller->store_id]);
            }

            $i = $i+1;
        }
        echo json_encode(array($storeIdsLists, $storeInfosLists));
    }
}
