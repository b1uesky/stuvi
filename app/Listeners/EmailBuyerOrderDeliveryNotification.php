<?php

namespace App\Listeners;

use App\Events\BuyerOrderDeliveryWasScheduled;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Snowfire;

class EmailBuyerOrderDeliveryNotification
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

        $data = array(
            'subject'           => 'Delivery: #' . $buyer_order->id,
            'to'                => 'express@stuvi.com',
            'buyer_order_id'    => $buyer_order->id,
            'scheduled_delivery_time'   => date(config('app.datetime_format'), strtotime($buyer_order->scheduled_delivery_time)),
        );

        $beautymail = app()->make(Snowfire\Beautymail\Beautymail::class);
        $beautymail->send('emails.express.deliveryNotification', $data, function($message) use ($data)
        {
            $message
                ->to($data['to'])
                ->subject($data['subject']);
        });
    }
}
