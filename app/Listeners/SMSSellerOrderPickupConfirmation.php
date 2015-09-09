<?php

namespace App\Listeners;

use App\Events\SellerOrderPickupWasScheduled;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SMSSellerOrderPickupConfirmation
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
        //
    }
}
