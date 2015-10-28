<?php

namespace App\Listeners;

use App\Events\BuyerOrderWasCancelled;
use App\Helpers\Email;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailBuyerOrderCancelledNotificationToBuyer
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
     * @param  BuyerOrderWasCancelled  $event
     * @return void
     */
    public function handle(BuyerOrderWasCancelled $event)
    {
        $buyer_order = $event->buyer_order;

        if ($buyer_order->isCancelledByBuyer())
        {
            $email = new Email(
                $subject = 'Your Stuvi order has been cancelled.',
                $to = $buyer_order->buyer->primaryEmailAddress(),
                $view = 'emails.buyerOrder.cancelled',
                $data = [
                    'buyer_order' => $buyer_order
                ]
            );

            $email->send();
        }
    }
}
