<?php

namespace App\Listeners;

use Aloha\Twilio\Twilio;
use App\Events\BuyerOrderDeliveryWasScheduled;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class MessageBuyerOrderDeliveryScheduledNotificationToStuvi
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
     * @param  BuyerOrderDeliveryWasScheduled  $event
     * @return void
     */
    public function handle(BuyerOrderDeliveryWasScheduled $event)
    {
        $buyer_order = $event->buyer_order;

        $twilio = new Twilio(
            config('twilio.twilio.connections.twilio.sid'),
            config('twilio.twilio.connections.twilio.token'),
            config('twilio.twilio.connections.twilio.from')
        );

        $phone_number = config('customer_service.phone');
        $message = 'Express Delivery: Buyer order #' . $buyer_order->id . '. '.
            'Scheduled time: ' . \App\Helpers\DateTime::showDatetime($buyer_order->scheduled_delivery_time).' '.
            url('/express/deliver/' . $buyer_order->id);

        $twilio->message($phone_number, $message);

        if (app()->environment() == 'production' && !env('APP_DEBUG')) {
            $twilio->message('8572064789', $message);
            $twilio->message('8572084775', $message);
        }
    }
}
