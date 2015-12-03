<?php

namespace App\Listeners;

use App\Events\BuyerOrderWasShipped;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class MessageBuyerOrderShippedNotificationToBuyer
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
     * @param  BuyerOrderWasShipped  $event
     * @return void
     */
    public function handle(BuyerOrderWasShipped $event)
    {
        //
    }
}
