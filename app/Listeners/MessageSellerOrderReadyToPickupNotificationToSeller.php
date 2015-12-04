<?php

namespace App\Listeners;

use Aloha\Twilio\Twilio;
use App\Events\SellerOrderWasAssignedToCourier;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class MessageSellerOrderReadyToPickupNotificationToSeller
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
     * @param  SellerOrderWasAssignedToCourier  $event
     * @return void
     */
    public function handle(SellerOrderWasAssignedToCourier $event)
    {
        $seller_order = $event->seller_order;

        $twilio = new Twilio(
            config('twilio.twilio.connections.twilio.sid'),
            config('twilio.twilio.connections.twilio.token'),
            config('twilio.twilio.connections.twilio.from')
        );

        $phone_number = $seller_order->seller()->phone_number;
        $message = 'Pickup: Stuvi courier is ready to pick up your textbook '.$seller_order->product->book->title.'. '.
            'Scheduled time: '. \App\Helpers\DateTime::showDatetime($seller_order->scheduled_pickup_time).' '.
            'Courier phone number: '.$seller_order->courier->phone_number. ' '.
            'Confirmation code: '.$seller_order->pickup_code;

        $twilio->message($phone_number, $message);
    }
}
