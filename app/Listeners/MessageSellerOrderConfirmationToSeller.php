<?php

namespace App\Listeners;

use App\Events\SellerOrderWasCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class MessageSellerOrderConfirmationToSeller
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
     * @param  SellerOrderWasCreated  $event
     * @return void
     */
    public function handle(SellerOrderWasCreated $event)
    {
        //
    }
}
