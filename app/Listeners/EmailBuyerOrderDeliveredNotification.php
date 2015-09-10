<?php

namespace App\Listeners;

use App\Events\BuyerOrderWasDelivered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Snowfire;

class EmailBuyerOrderDeliveredNotification
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
     * @param  BuyerOrderWasDelivered  $event
     * @return void
     */
    public function handle(BuyerOrderWasDelivered $event)
    {
        $buyer_order = $event->buyer_order;

        $data = array(
            'subject'           => 'Your Stuvi order has Delivered!',
            'to'                => $buyer_order->buyer->primaryEmailAddress(),
        );

        $beautymail = app()->make(Snowfire\Beautymail\Beautymail::class);
        $beautymail->send('emails.buyerOrder.deliveredNotification', ['buyer_order'  => $buyer_order], function($message) use ($data)
        {
            $message
                ->to($data['to'])
                ->subject($data['subject']);
        });
    }
}
