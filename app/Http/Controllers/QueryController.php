<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Mail\CustomerQuery;
use Illuminate\Support\Facades\Mail;

class QueryController extends Controller
{
    //
    public function store(Request $request) {
        $this->validate($request, [
            'firstname' => 'max:255',
            'lastname' => 'max:255', 
            'email' => 'email|required|max:255',
            'phone' => 'max:25',
            'message' => 'required|max:1023'
        ]);
        $queryId = DB::table('queries')
                ->insertGetId(['first_name' => $request->firstname, 'last_name' => $request->lastname, 'email' => $request->email, 'phone' => $request->phone, 'query' => $request->message]);
        $query = DB::table('queries')
                ->where('id', $queryId)
                ->first();

        // sending mail to admin
        Mail::to('grabbitindia.mail@gmail.com')->send(new CustomerQuery($query));

        return back()->with('success', 'Your query has been registered. We will get back to you as soon as possible. Thank you for you patience.');
    }
}
