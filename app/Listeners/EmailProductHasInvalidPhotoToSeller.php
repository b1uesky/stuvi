<?php

namespace App\Listeners;

use App\Events\ProductHasInvalidPhoto;
use App\Helpers\Email;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailProductHasInvalidPhotoToSeller
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
     * @param  ProductHasInvalidPhoto  $event
     * @return void
     */
    public function handle(ProductHasInvalidPhoto $event)
    {
        $product = $event->product;

        $seller = $product->seller;
        $book_title = $product->book->title;

        $email = new Email(
            $subject = 'Please update your book photos',
            $to = $seller->primaryEmailAddress(),
            $view = 'emails.product.invalid-photo',
            $data = [
                'product'           => $product,
                'first_name'        => $seller->first_name,
                'book_title'        => $book_title
            ]
        );

        $email->send();
    }
}
