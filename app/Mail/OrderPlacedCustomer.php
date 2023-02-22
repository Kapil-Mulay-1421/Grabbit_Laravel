<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class OrderPlacedCustomer extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $username;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order)
    {
        //
        $this->order = $order;
        $this->username = DB::table('customers')
                ->where('customer_id', $order->customer_id)
                ->value('first_name');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Order Confirmed')
                    ->view('emails.orderPlacedCustomer');
    }
}
