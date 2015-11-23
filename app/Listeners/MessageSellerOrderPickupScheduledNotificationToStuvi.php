<?php

namespace App\Listeners;

use App\Events\SellerOrderPickupWasScheduled;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class MessageSellerOrderPickupScheduledNotificationToStuvi
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
     * @param  SellerOrderPickupWasScheduled  $event
     * @return void
     */
    public function handle(SellerOrderPickupWasScheduled $event)
    {
        $seller_order = $event->seller_order;

        $twilio = new Twilio(
            config('twilio.twilio.connections.twilio.sid'),
            config('twilio.twilio.connections.twilio.token'),
            config('twilio.twilio.connections.twilio.from')
        );

        $phone_number = config('customer_service.phone');
        $message = 'Pickup: Seller order #' . $seller_order->id . ' was scheduled at ' . $seller_order->scheduled_pickup_time . '.';

        $twilio->message($phone_number, $message);
//        $twilio->message('8572064789', $message);
//        $twilio->message('8572084775', $message);
    }
}
