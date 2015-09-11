<?php

namespace App\Listeners;

use App\Events\BuyerOrderWasCancelled;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Snowfire;

class EmailBuyerOrderCancelledNotification
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

        if ($buyer_order->isCancelledByBuyer())
        {
            $data = array(
                'subject'           => 'Your Stuvi order has been cancelled.',
                'to'                => $buyer_order->buyer->primaryEmailAddress(),
            );

            $beautymail = app()->make(Snowfire\Beautymail\Beautymail::class);
            $beautymail->send('emails.buyerOrder.cancelledNotification', ['buyer_order' => $buyer_order], function($message) use ($data)
            {
                $message
                    ->to($data['to'])
                    ->subject($data['subject']);
            });
        }
    }
}
