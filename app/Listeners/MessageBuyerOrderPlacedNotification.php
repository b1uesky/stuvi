<?php

namespace App\Listeners;

use App\Events\BuyerOrderWasPlaced;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class MessageBuyerOrderPlacedNotification
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
     * @param  BuyerOrderWasPlaced  $event
     * @return void
     */
    public function handle(BuyerOrderWasPlaced $event)
    {
        $buyer_order = $event->buyer_order;

        $twilio = new Twilio(
            config('twilio.twilio.connections.twilio.sid'),
            config('twilio.twilio.connections.twilio.token'),
            config('twilio.twilio.connections.twilio.from')
        );

        $phone_number = config('customer_service.phone');
        $message = 'Buyer order #' . $buyer_order->id . ' was created!';

        $twilio->message($phone_number, $message);
    }
}
