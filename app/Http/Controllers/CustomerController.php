<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

use Symfony\Component\HttpFoundation\Response;

use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // No index, can't publicize user data lol.
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Won't be needed as creation happens at the time of sign in automatically through auth.
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Data should come in from auth.
        $userId = $request->input('id'); // assuming id will be obtained from auth at the time of user creation.
        $email = $request->input('email');
        DB::table('customers')
                ->where('customer_id', $userId)
                ->insert(['email' => $email]);

        return response()->noContent(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Won't be needed as covered in profile controller form.
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        // Won't be needed as covered in profile controller form.
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //

        $request->validate([
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'phone' => ['max:25'],
        ]);

        $userId = auth()->user()->id;
        $affected = DB::table('customers')
                ->where('customer_id', $userId)
                ->update(['first_name' => $request->input('firstname'), 'last_name' => $request->input('lastname'), 'phone' => $request->input('phone')]);
        DB::table('users')
                ->where('id', $userId)
                ->update(['name' => $request->input('firstname')]);
        if($affected == 1) {
            return redirect('/profile/account')->with('success', 'The changes were successfully made.');
        } else {
            return redirect('/profile/account')->with('error', 'Something went wrong, please try again.');
        }
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
    }
}
