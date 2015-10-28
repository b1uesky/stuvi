<?php

namespace App\Listeners;

use App\Events\BuyerOrderDeliveryWasScheduled;
use App\Helpers\DateTime;
use App\Helpers\Email;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailBuyerOrderDeliveryScheduledNotificationToStuvi
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

        $email = new Email(
            $subject = 'Delivery: #' . $buyer_order->id,
            $to = 'express@stuvi.com',
            $view = 'emails.express.delivery',
            $data = [
                'buyer_order_id'    => $buyer_order->id,
                'scheduled_delivery_time'   => DateTime::showDatetime($buyer_order->scheduled_delivery_time),
            ]
        );

        $email->send();
    }
}
