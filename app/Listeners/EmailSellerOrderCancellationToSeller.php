<?php

namespace App\Listeners;

use App\Events\SellerOrderWasCancelled;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Snowfire;

class EmailSellerOrderCancellationToSeller
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

        if ($seller_order->isCancelledBySeller())
        {
            $data = array(
                'subject'           => 'Your have cancelled your Stuvi order ' . $seller_order->book()->title . '.',
                'to'                => $seller_order->seller()->primaryEmailAddress(),
            );

            $beautymail = app()->make(Snowfire\Beautymail\Beautymail::class);
            $beautymail->send('emails.sellerOrder.cancelledBySellerNotificationToSeller', ['seller_order' => $seller_order], function($message) use ($data)
            {
                $message
                    ->to($data['to'])
                    ->subject($data['subject']);
            });
        }
        else
        {
            $data = array(
                'subject'           => 'Your book buyer has decided not to purchase your book ' . $seller_order->book()->title . '.',
                'to'                => $seller_order->seller()->primaryEmailAddress(),
            );

            $beautymail = app()->make(Snowfire\Beautymail\Beautymail::class);
            $beautymail->send('emails.sellerOrder.cancelledByBuyerNotificationToSeller', ['seller_order' => $seller_order], function($message) use ($data)
            {
                $message
                    ->to($data['to'])
                    ->subject($data['subject']);
            });
        }
    }
}
