<?php

namespace App\Listeners;

use App\Events\BuyerOrderWasShipped;
use App\Helpers\Email;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailBuyerOrderShippedNotificationToBuyer
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
     * @param  BuyerOrderWasShipped  $event
     * @return void
     */
    public function handle(BuyerOrderWasShipped $event)
    {
        $buyer_order = $event->buyer_order;

        $email = new Email(
            $subject = 'Your Stuvi order has shipped!',
            $to = $buyer_order->buyer->primaryEmailAddress(),
            $view = 'emails.buyerOrder.shipping',
            $data = [
                'buyer_order'  => $buyer_order
            ]
        );

        $email->send();
    }
}
