<?php

namespace App\Listeners;

use App\Events\SellerOrderWasCancelled;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Snowfire;

class EmailSellerOrderCancellationToBuyer
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
     * @param  SellerOrderWasCancelled  $event
     * @return void
     */
    public function handle(SellerOrderWasCancelled $event)
    {
        $seller_order = $event->seller_order;

        // only send email to buyer if the seller order is cancelled by seller (not buyer)
        if ($seller_order->isCancelledBySeller())
        {
            $data = array(
                'subject'           => 'Your Stuvi order ' . $seller_order->book()->title . ' was cancelled by the seller.',
                'to'                => $seller_order->buyerOrder->buyer->primaryEmail->email_address,
            );

            $beautymail = app()->make(Snowfire\Beautymail\Beautymail::class);
            $beautymail->send('emails.sellerOrder.cancellationNotificationToBuyer', ['seller_order' => $seller_order], function($message) use ($data)
            {
                $message
                    ->to($data['to'])
                    ->subject($data['subject']);
            });
        }
    }
}
