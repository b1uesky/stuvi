<?php

namespace App\Listeners;

use App\Events\SellerOrderWasCancelled;
use App\Helpers\Email;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailSellerOrderCancelledToSeller
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

        if ($seller_order->isCancelledBySeller())
        {
            $email = new Email(
                $subject = 'Your have cancelled your Stuvi order ' . $seller_order->book()->title . '.',
                $to = $seller_order->seller()->primaryEmailAddress(),
                $view = 'emails.sellerOrder.cancelled-by-seller-to-seller',
                $data = [
                    'seller_order' => $seller_order
                ]
            );
        }
        else
        {
            $email = new Email(
                $subject = 'Your book buyer has decided not to purchase your book ' . $seller_order->book()->title . '.',
                $to = $seller_order->seller()->primaryEmailAddress(),
                $view = 'emails.sellerOrder.cancelled-by-buyer-to-seller',
                $data = [
                    'seller_order' => $seller_order
                ]
            );
        }

        $email->send();
    }
}
