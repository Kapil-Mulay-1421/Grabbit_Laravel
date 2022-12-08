<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerAddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // The index function already exists as a part of ProfileController.
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('addresses.create');
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

        $userId = auth()->user()->id;

        $this->validate($request, [
            'address' => 'required', 
            'city' => 'required', 
            'state' => 'required', 
            'country' => 'required'
        ]);

        // Storing the address upon validation

        DB::table('customer_addresses')
                ->insert([
                    'customer_id'=>$userId, 
                    'address'=>$request->input('address'),
                    'city'=>$request->input('city'),
                    'state'=>$request->input('state'),
                    'country'=>$request->input('country')
                ]);
        return redirect('/profile/addresses')->with('success', 'Address Saved');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Getting the preset info of the address
        $preset = DB::table('customer_addresses')
                ->where('address_id', $id)
                ->first();

        return view('addresses.edit', ['preset'=>$preset]);
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
        $userId = auth()->user()->id;

        $this->validate($request, [
            'address' => 'required', 
            'city' => 'required', 
            'state' => 'required', 
            'country' => 'required'
        ]);

        // Storing the address upon validation

        DB::table('customer_addresses')
                ->where('address_id', $id)
                ->where('customer_id', $userId)
                ->update([
                    'address'=>$request->input('address'),
                    'city'=>$request->input('city'),
                    'state'=>$request->input('state'),
                    'country'=>$request->input('country')
                ]);
        return redirect('/profile/addresses')->with('success', 'Address Saved');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $userId = auth()->user()->id;
        DB::table('customer_addresses')
                ->where('address_id', $id)
                ->where('customer_id', $userId)
                ->delete();
        return redirect('/profile/addresses')->with('success', 'Address Removed');
    }

    public function setActive($id) {
        $userId = auth()->user()->id;
        $address = DB::table('customer_addresses')
                ->where('address_id', $id)
                ->where('customer_id', $userId)
                ->first();
        // We know that the address id belongs to the user if $address is not null.
        $addressId = $address->address_id;
        DB::table('customers')
                ->where('customer_id', $userId)
                ->update(['active_address' => $addressId]);
        return redirect('/profile/addresses')->with('success', 'Address Activated');
    }
}
