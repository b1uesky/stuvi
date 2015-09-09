<?php

namespace App\Listeners;

use App\Events\SellerOrderPickupWasScheduled;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Snowfire;

class EmailSellerOrderPickupNotification
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

        $data = array(
            'subject'           => 'Pickup: #' . $seller_order->id . ' - ' . $seller_order->book()->title,
            'to'                => 'express@stuvi.com',
            'seller_order_id'   => $seller_order->id,
            'book_title'        => $seller_order->book()->title,
            'time'              => date(config('app.datetime_format'), strtotime($seller_order->scheduled_pickup_time)),
        );

        $beautymail = app()->make(Snowfire\Beautymail\Beautymail::class);
        $beautymail->send('emails.express.pickupNotification', $data, function($message) use ($data)
        {
            $message
                ->to($data['to'])
                ->subject($data['subject']);
        });
    }
}
