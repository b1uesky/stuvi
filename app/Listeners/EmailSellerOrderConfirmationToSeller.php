<?php

namespace App\Listeners;

use App\Events\SellerOrderWasCreated;
use App\Helpers\Email;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailSellerOrderConfirmationToSeller
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
     * @param  SellerOrderWasCreated  $event
     * @return void
     */
    public function handle(SellerOrderWasCreated $event)
    {
        $seller_order = $event->seller_order;

        $email = new Email(
            $subject = 'Your book ' . $seller_order->book()->title . ' has sold',
            $to = $seller_order->seller()->primaryEmailAddress(),
            $view = 'emails.sellerOrder.confirmation',
            $data = [
                'first_name'        => $seller_order->seller()->first_name,
                'book_title'        => $seller_order->book()->title,
                'seller_order_id'   => $seller_order->id,
            ]
        );

        $email->send();
    }
}
