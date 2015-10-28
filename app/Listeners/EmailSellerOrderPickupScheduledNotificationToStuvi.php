<?php

namespace App\Listeners;

use App\Events\SellerOrderPickupWasScheduled;
use App\Helpers\DateTime;
use App\Helpers\Email;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailSellerOrderPickupScheduledNotificationToStuvi
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

        $email = new Email(
            $subject = 'Pickup: #' . $seller_order->id . ' - ' . $seller_order->book()->title,
            $to = 'express@stuvi.com',
            $view = 'emails.express.pickupNotification',
            $data = [
                'seller_order_id'   => $seller_order->id,
                'book_title'        => $seller_order->book()->title,
                'time'              => DateTime::showDatetime($seller_order->scheduled_pickup_time),
            ]
        );

        $email->send();
    }
}
