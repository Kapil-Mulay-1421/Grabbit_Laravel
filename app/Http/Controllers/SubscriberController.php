<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubscriberController extends Controller
{
    //

    public function store(Request $request) {
        $email = $request->input('email');

        $request->validate([
            'email' => 'email:rfc,dns'
        ]);

        $exists = DB::table('subscribers')
                ->where('email', $email)
                ->exists();

        if ($exists) {
            return redirect('/home')->with('error', 'Already registered.');
        }

        $currDate = date("Y-m-d");
        $affected = DB::table('subscribers')
                ->insert(['email' => $email, 'subscribedon' => $currDate]);
        
        $affectedCustomers = DB::table('customers')
                ->where('email', $email)
                ->update(['subscribed' => true, 'sub_token_used' => false]);

        if ($affected == 1) {
            return redirect('/home')->with('success', 'Thank You for Subscribing!');
        } else {
            return redirect('/home')->with('error', 'Sorry, something went wrong. Please try again.');
        }
    }
}
