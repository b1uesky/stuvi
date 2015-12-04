<?php

namespace App\Listeners;

use App\Events\SellerOrderWasPickedUp;
use App\Helpers\Email;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailSellerOrderPickedupNotificationToSeller
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
     * @param  SellerOrderWasPickedUp  $event
     * @return void
     */
    public function handle(SellerOrderWasPickedUp $event)
    {
        $seller_order = $event->seller_order;

        $email = new Email(
            $subject = 'Your textbook has been picked up',
            $to = $seller_order->seller()->primaryEmailAddress(),
            $view = 'emails.sellerOrder.pickedup',
            $data = [
                'first_name'        => $seller_order->seller()->first_name,
                'book_title'        => $seller_order->book()->title,
                'seller_order'   => $seller_order,
            ]
        );

        $email->send();
    }
}
