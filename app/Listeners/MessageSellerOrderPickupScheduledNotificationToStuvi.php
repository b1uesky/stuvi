<?php

namespace App\Listeners;

use Aloha\Twilio\Twilio;
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
        $message = 'Express Pickup: '. $seller_order->book()->title.'. '.
            'Scheduled time: ' . \App\Helpers\DateTime::showDatetime($seller_order->scheduled_pickup_time) . ' '.
            url('/express/pickup/' . $seller_order->id);

        $twilio->message($phone_number, $message);

        if (app()->environment() == 'production' && !env('APP_DEBUG')) {
            $twilio->message('8572064789', $message);
            $twilio->message('8572084775', $message);
        }
    }
}
