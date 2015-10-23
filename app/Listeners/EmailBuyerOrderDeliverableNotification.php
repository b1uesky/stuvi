<?php

namespace App\Listeners;

use App\Events\BuyerOrderWasDeliverable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Snowfire;

class EmailBuyerOrderDeliverableNotification
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

        $data = array(
            'subject'           => 'Schedule a delivery time for your books.',
            'to'                => $buyer_order->buyer->primaryEmailAddress(),
            'first_name'        => $buyer_order->buyer->first_name,
            'buyer_order_id'    => $buyer_order->id
        );

        $beautymail = app()->make(Snowfire\Beautymail\Beautymail::class);
        $beautymail->send('emails.buyerOrder.deliverableNotification', $data, function($message) use ($data)
        {
            $message
                ->to($data['to'])
                ->subject($data['subject']);
        });
    }
}
