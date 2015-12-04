<?php

namespace App\Listeners;

use Aloha\Twilio\Twilio;
use App\Events\BuyerOrderWasShipped;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class MessageBuyerOrderShippedNotificationToBuyer
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
     * @param  BuyerOrderWasShipped  $event
     * @return void
     */
    public function handle(BuyerOrderWasShipped $event)
    {
        $buyer_order = $event->buyer_order;

        $twilio = new Twilio(
            config('twilio.twilio.connections.twilio.sid'),
            config('twilio.twilio.connections.twilio.token'),
            config('twilio.twilio.connections.twilio.from')
        );

        $phone_number = $buyer_order->buyer->phone_number;
        $message = 'Shipping: Stuvi courier is ready to deliver your order. '.
            'Scheduled time: '. \App\Helpers\DateTime::showDatetime($buyer_order->scheduled_delivery_time).' '.
            'Courier phone number: '.$buyer_order->courier->phone_number.' '.
            'Confirmation code: '.$buyer_order->delivery_code;

        $twilio->message($phone_number, $message);
    }
}
