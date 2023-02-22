<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FeedbackController extends Controller
{
    //

    public function store(Request $request) {

        $userId = auth()->user()->id;

        $validated = $request->validate([
            'feedback' => 'required|max:1023'
        ]);

        $date = date('Y-m-d H:i:s');

        DB::table('feedback')
                ->insert([
                    'customer_id' => $userId,
                    'feedback' => $validated['feedback'], 
                    'created_at' => $date, 
                ]);
        return redirect('/home')->with('success', 'Thank you for submitting your feedback.');
    }
}
