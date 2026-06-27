<?php

namespace App\Listeners;

use App\Events\PaymentReceived;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\OrderPlacedCustomer;
use App\Mail\OrderPlacedAdmin;

class NotifyOrderPlaced
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\PaymentReceived  $event
     * @return void
     */
    public function handle(PaymentReceived $event)
    {
        //
        // Giving the user payment received confirmation
        try {
            Mail::to($event->customerEmail)->send(new OrderPlacedCustomer($event->order));
        } catch(\Exception $e) {
            Log::error($e);
        }
        Log::info($event->order->order_status);
        try {
            Mail::to('grabbitindia.mail@gmail.com')->send(new OrderPlacedAdmin($event->order, $event->orderItems, $event->paymentMethod));
        } catch(\Exception $e) {
            Log::error($e);
        }
    }
}
