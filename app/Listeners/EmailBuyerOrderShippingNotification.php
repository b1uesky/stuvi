<?php

namespace App\Listeners;

use App\Events\BuyerOrderWasShipped;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Snowfire;

class EmailBuyerOrderShippingNotification
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
        $buyer_order = $event->buyer_order;

        $data = array(
            'subject'           => 'Your Stuvi order has shipped!',
            'to'                => $buyer_order->buyer->primaryEmailAddress(),
        );

        $buyer_order_arr = $buyer_order->allToArray();

        $beautymail = app()->make(Snowfire\Beautymail\Beautymail::class);
        $beautymail->send('emails.buyerOrder.shipped', $data, function($message) use ($data, $buyer_order_arr)
        {
            $message
                ->to($data['to'])
                ->subject($data['subject']);
        });
    }
}
