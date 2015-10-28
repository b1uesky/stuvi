<?php

namespace App\Listeners;

use App\Events\SellerOrderWasCancelled;
use App\Helpers\Email;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailSellerOrderCancelledToBuyer
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
     * @param  SellerOrderWasCancelled  $event
     * @return void
     */
    public function handle(SellerOrderWasCancelled $event)
    {
        $seller_order = $event->seller_order;

        // only send email to buyer if the seller order is cancelled by seller (not buyer)
        if ($seller_order->isCancelledBySeller())
        {
            $email = new Email(
                $subject = 'Your Stuvi order ' . $seller_order->book()->title . ' was cancelled by the seller.',
                $to = $seller_order->buyerOrder->buyer->primaryEmailAddress(),
                $view = 'emails.sellerOrder.cancellationNotificationToBuyer',
                $data = [
                    'seller_order' => $seller_order
                ]
            );

            $email->send();
        }
    }
}
