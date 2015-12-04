<?php

namespace App\Listeners;

use Aloha\Twilio\Twilio;
use App\Events\BuyerOrderWasDeliverable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class MessageBuyerOrderDeliverableNotificationToBuyer
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
     * @param  BuyerOrderWasDeliverable  $event
     * @return void
     */
    public function handle(BuyerOrderWasDeliverable $event)
    {
        $buyer_order = $event->buyer_order;

        $twilio = new Twilio(
            config('twilio.twilio.connections.twilio.sid'),
            config('twilio.twilio.connections.twilio.token'),
            config('twilio.twilio.connections.twilio.from')
        );

        $phone_number = $buyer_order->buyer->phone_number;
        $message = 'Schedule a delivery: Your Stuvi order is ready. '.
            'Please schedule a delivery at your convenience: '.
            url('/order/buyer/' . $buyer_order->id . '/scheduleDelivery');

        $twilio->message($phone_number, $message);
    }
}
