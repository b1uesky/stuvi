<?php

namespace App\Listeners;

use App\Events\BuyerOrderWasDelivered;
use App\Helpers\Email;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailBuyerOrderDeliveredNotificationToBuyer
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

        $email = new Email(
            $subject = 'Your Stuvi order has Delivered.',
            $to = $buyer_order->buyer->primaryEmailAddress(),
            $view = 'emails.buyerOrder.delivered',
            $data = [
                'buyer_order'  => $buyer_order
            ]
        );

        $email->send();
    }
}
