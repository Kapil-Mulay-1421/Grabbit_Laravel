<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class OrderPlacedAdmin extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $orderItems;
    public $username;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order, $orderItems)
    {
        //
        $this->order = $order;
        $this->orderItems = $orderItems;
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
        return $this->subject('New Order Placed on Grabbit')
                    ->view('emails.orderPlacedAdmin');
    }
}
