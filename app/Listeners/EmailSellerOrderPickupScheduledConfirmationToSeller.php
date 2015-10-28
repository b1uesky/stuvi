<?php

namespace App\Listeners;

use App\Events\SellerOrderPickupWasScheduled;
use App\Helpers\DateTime;
use App\Helpers\Email;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailSellerOrderPickupScheduledConfirmationToSeller
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
            $subject = 'Your have scheduled a pickup for ' . $seller_order->book()->title . '.',
            $to = $seller_order->seller()->primaryEmailAddress(),
            $view = 'emails.sellerOrder.pickup-scheduled',
            $data = [
                'seller_order'      => $seller_order,
                'first_name'        => $seller_order->seller()->first_name,
                'book_title'        => $seller_order->book()->title
            ]
        );

        $email->send();
    }
}
