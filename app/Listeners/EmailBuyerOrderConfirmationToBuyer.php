<?php

namespace App\Listeners;

use App\Events\BuyerOrderWasPlaced;
use App\Helpers\Email;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailBuyerOrderConfirmationToBuyer
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
     * @param  BuyerOrderWasPlaced  $event
     * @return void
     */
    public function handle(BuyerOrderWasPlaced $event)
    {
        $buyer_order = $event->buyer_order;

        $email = new Email(
            $subject = 'Your Stuvi order confirmation.',
            $to = $buyer_order->buyer->primaryEmailAddress(),
            $view = 'emails.buyerOrder.confirmation',
            $data = [
                'first_name'        => $buyer_order->buyer->first_name,
                'buyer_order_id'    => $buyer_order->id
            ]
        );

        $email->send();
    }
}
