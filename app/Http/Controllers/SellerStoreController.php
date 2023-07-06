<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SellerStoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userId = auth()->user()->id;
        // This is a function that queries the database for data about the stores owned by the user and returns the stores listing view.
        $storesFromDatabase = DB::table('stores')
                ->where('owner_customer_id', '=', $userId)
                ->get();
        return view('seller.stores', ['stores' => $storesFromDatabase]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('seller.createStore');
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
        $request->validate([
            'name' => 'required|max:45', 
            'phone' => 'required|max:45', 
            'email' => 'required|email', 
            'street' => 'required|max:45', 
            'city' => 'required|max:45', 
            'state' => 'required|max:45', 
            'description' => 'required|max:1023', 
            'opens_at' => 'required|max:45', 
            'closes_at' => 'required|max:45', 
            'image' => 'required|image|max:1024', 
        ]);

        $userId = auth()->user()->id;

        $id = DB::table('stores')
                ->insertGetId([
                    'owner_customer_id' => $userId, 
                    'store_name' => $request->name, 
                    'phone' => $request->phone, 
                    'email' => $request->email, 
                    'street' => $request->street,
                    'city' => $request->city,
                    'state' => $request->state,
                    'description' => $request->description,
                    'opens_at' => $request->opens_at,
                    'closes_at' => $request->closes_at,
                ]);

        $imagePath = 'images/stores/';
        $imageName = $id.".".$request->image->extension();
        Storage::disk('public')->putFileAs($imagePath, $request->image, $imageName);

        $url = Storage::url($imagePath.$imageName);

        DB::table('stores')
                ->where('store_id', $id)
                ->update([
                    'image' => $url, 
                ]);

        return redirect('/my-stores')->with('Store successfully created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $userId = auth()->user()->id;
        //this is a function that displays the specified resource

        //when product_id is used to view a product
        $storeFromDatabase = DB::table('stores')
                ->where('stores.store_id', '=', $id)
                ->where('owner_customer_id', $userId)
                ->first(); 
        return view('store', ['store' => $storeFromDatabase]);
        //echo($storeFromDatabase);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $userId = auth()->user()->id;
        $storeFromDatabase = DB::table('stores')
                ->where('stores.store_id', '=', $id)
                ->where('owner_customer_id', $userId)
                ->first(); 
        return view('seller.store', ['store' => $storeFromDatabase]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $request->validate([
            'name' => 'required|max:45', 
            'phone' => 'required|max:45', 
            'email' => 'required|email', 
            'street' => 'required|max:45', 
            'city' => 'required|max:45', 
            'state' => 'required|max:45', 
            'description' => 'required|max:1023', 
            'opens_at' => 'required|max:45', 
            'closes_at' => 'required|max:45', 
            'image' => 'image|max:1024', 
        ]);

        $userId = auth()->user()->id;

        $affected = DB::table('stores')
                ->where('owner_customer_id', $userId)
                ->where('store_id', $id)
                ->update([
                    'owner_customer_id' => $userId, 
                    'store_name' => $request->name, 
                    'phone' => $request->phone, 
                    'email' => $request->email, 
                    'street' => $request->street,
                    'city' => $request->city,
                    'state' => $request->state,
                    'description' => $request->description,
                    'opens_at' => $request->opens_at,
                    'closes_at' => $request->closes_at,
                ]);

        if($affected == 1 && $request->image != null) {
            $imagePath = 'images/stores/';
            $imageName = $id.".".$request->image->extension();
            Storage::disk('public')->putFileAs($imagePath, $request->image, $imageName);
    
            $url = Storage::url($imagePath.$imageName);
    
            DB::table('stores')
                    ->where('store_id', $id)
                    ->update([
                        'image' => $url, 
                    ]);
        }
        return redirect('/my-stores')->with('success', 'Successfully updated store info.');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $userId = auth()->user()->id; 
        $affected = DB::table('stores')
        ->where('owner_customer_id' , '=' , $userId)
        ->where('store_id', '=' , $id)
        ->delete();
        if($affected = 1)
        {
            return redirect('/my-stores')->with('success' , 'store deleted successfully.');
        }
        else
        {
             return redirect('/my-stores')->with('error' , 'invalid request');
        }
        
    }

}