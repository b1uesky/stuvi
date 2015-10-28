<?php

namespace App\Listeners;

use App\Events\ProductWasUpdatedPriceAndApproved;
use App\Helpers\Email;
use App\Product;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailProductUpdatedPriceAndApprovedNotificationToSeller
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

        $email = new Email(
            $subject = 'Your book ' . $book_title . ' has been accepted by Stuvi.',
            $to = $seller->primaryEmailAddress(),
            $view = 'emails.product.updatedPriceAndApprovedNotification',
            $data = [
                'seller_order'      => $seller_order,
                'first_name'        => $seller->first_name,
                'book_title'        => $book_title
            ]
        );

        $email->send();
    }
}
