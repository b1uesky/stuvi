<?php

namespace App\Listeners;

use App\Events\BuyerOrderWasDelivered;
use App\Helpers\Email;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailBuyerOrderDeliveredNotificationToSeller
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

        // email every seller related to this buyer order
        foreach ($buyer_order->seller_orders as $seller_order)
        {
            $email = new Email(
                $subject = 'Your textbook has been delivered to the buyer',
                $to = $seller_order->seller()->primaryEmailAddress(),
                $view = 'emails.buyerOrder.delivered-notify-seller',
                $data = [
                    'first_name'        => $seller_order->seller()->first_name,
                    'book_title'        => $seller_order->book()->title,
                    'seller_order'      => $seller_order,
                ]
            );

            $email->send();
        }
    }
}
