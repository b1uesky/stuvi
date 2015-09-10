<?php

namespace App\Listeners;

use Aloha\Twilio\Twilio;
use App\Events\SellerOrderWasCancelled;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class MessageSellerOrderCancellationToCourier
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
     * @param  SellerOrderWasCancelled  $event
     * @return void
     */
    public function handle(SellerOrderWasCancelled $event)
    {
        $seller_order = $event->seller_order;

        if ($seller_order->assignedToCourier())
        {
            $twilio = new Twilio(
                config('twilio.twilio.connections.twilio.sid'),
                config('twilio.twilio.connections.twilio.token'),
                config('twilio.twilio.connections.twilio.from')
            );

            $phone_number = $seller_order->courier->phone_number;
            $message = 'Seller order #' . $seller_order->id . ' has been cancelled by the seller at ' . $seller_order->getCancelledTime();

            $twilio->message($phone_number, $message);
        }
    }
}
