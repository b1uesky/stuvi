<?php

namespace App\Listeners;

use App\Events\ProductWasUpdatedPriceAndApproved;
use App\Product;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Snowfire;

class EmailSellerProductUpdatedPriceAndApprovedNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param  ProductWasUpdatedPriceAndApproved  $event
     * @return void
     */
    public function handle(ProductWasUpdatedPriceAndApproved $event)
    {
        $seller_order = $event->seller_order;
        $seller = $seller_order->product->seller;
        $book_title = $seller_order->product->book->title;

        $data = array(
            'subject'           => 'Your book ' . $book_title . ' has been accepted by Stuvi.',
            'to'                => $seller->primaryEmailAddress(),
            'seller_order'      => $seller_order,
            'first_name'        => $seller->first_name,
            'book_title'        => $book_title
        );

        $beautymail = app()->make(Snowfire\Beautymail\Beautymail::class);
        $beautymail->send('emails.product.updatedPriceAndApprovedNotification', $data, function($message) use ($data)
        {
            $message
                ->to($data['to'])
                ->subject($data['subject']);
        });
    }
}
