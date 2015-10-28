<?php

namespace App\Listeners;

use App\Events\BuyerOrderWasDelivered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreatePaypalPayoutToSellers
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
        $event->buyer_order->payout();
    }
}
