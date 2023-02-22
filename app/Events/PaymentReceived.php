<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PaymentReceived
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $order;
    public $orderItems;
    public $paymentMethod;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($order, $orderItems, $paymentMethod, $customerEmail)
    {
        //
        $this->order = $order;
        $this->orderItems = $orderItems;
        $this->paymentMethod = $paymentMethod;
        $this->customerEmail = $customerEmail;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
