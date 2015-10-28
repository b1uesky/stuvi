<?php

namespace App\Listeners;

use App\Events\BuyerOrderWasDeliverable;
use App\Helpers\Email;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailBuyerOrderDeliverableNotificationToBuyer
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
     * @param  BuyerOrderWasDeliverable  $event
     * @return void
     */
    public function handle(BuyerOrderWasDeliverable $event)
    {
        $buyer_order = $event->buyer_order;

        $email = new Email(
            $subject = 'Schedule a delivery time for your books.',
            $to = $buyer_order->buyer->primaryEmailAddress(),
            $view = 'emails.buyerOrder.deliverableNotification',
            $data = [
                'first_name'        => $buyer_order->buyer->first_name,
                'buyer_order_id'    => $buyer_order->id
            ]
        );

        $email->send();
    }
}
