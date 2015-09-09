<?php

namespace App\Listeners;

use App\Events\BuyerOrderWasPlaced;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Snowfire;

class EmailBuyerOrderConfirmation
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

        $data = array(
            'subject'           => 'Your Stuvi order confirmation',
            'to'                => $buyer_order->buyer->primaryEmailAddress(),
            'first_name'        => $buyer_order->buyer->first_name,
            'buyer_order_id'    => $buyer_order->id
        );

        $beautymail = app()->make(Snowfire\Beautymail\Beautymail::class);
        $beautymail->send('emails.buyerOrder.confirmation', $data, function($message) use ($data)
        {
            $message
                ->to($data['to'])
                ->subject($data['subject']);
        });
    }
}
