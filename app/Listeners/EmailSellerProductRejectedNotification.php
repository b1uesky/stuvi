<?php

namespace App\Listeners;

use App\Events\ProductWasRejected;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Snowfire;

class EmailSellerProductRejectedNotification
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
     * @param  ProductWasRejected  $event
     * @return void
     */
    public function handle(ProductWasRejected $event)
    {
        $product = $event->product;
        $seller = $product->seller;
        $book_title = $product->book->title;

        $data = array(
            'subject'           => 'Sorry, your book ' . $book_title . ' is not accepted by Stuvi.',
            'to'                => $seller->primaryEmailAddress(),
            'product'           => $product,
            'first_name'        => $seller->first_name,
            'book_title'        => $book_title
        );

        $beautymail = app()->make(Snowfire\Beautymail\Beautymail::class);
        $beautymail->send('emails.product.rejectedNotification', $data, function($message) use ($data)
        {
            $message
                ->to($data['to'])
                ->subject($data['subject']);
        });
    }
}
