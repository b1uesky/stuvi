<?php

namespace App\Listeners;

use App\Events\SellerOrderWasAssignedToCourier;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SMSSellerOrderReadyToPickupNotification
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
     * @param  SellerOrderWasAssignedToCourier  $event
     * @return void
     */
    public function handle(SellerOrderWasAssignedToCourier $event)
    {
        //
    }
}
