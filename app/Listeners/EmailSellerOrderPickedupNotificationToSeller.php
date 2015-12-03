<?php

namespace App\Listeners;

use App\Events\SellerOrderWasPickedUp;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailSellerOrderPickedupNotificationToSeller
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
     * @param  SellerOrderWasPickedUp  $event
     * @return void
     */
    public function handle(SellerOrderWasPickedUp $event)
    {
        //
    }
}
