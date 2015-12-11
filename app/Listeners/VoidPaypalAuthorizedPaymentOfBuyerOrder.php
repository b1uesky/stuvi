<?php

namespace App\Listeners;

use App\Events\BuyerOrderWasCancelled;
use App\Helpers\Paypal;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class VoidPaypalAuthorizedPaymentOfBuyerOrder
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

        if ($buyer_order->payment_method == 'paypal' && $buyer_order->authorization_id)
        {
            $paypal = new Paypal();
            $paypal->voidAuthorization($event->buyer_order->authorization_id);
        }
    }
}
