<?php

return [
    'title'     => 'Products',
    'single'    => 'product',
    'model'     => 'App\Product',

    'columns'   => [

        'id'    => [
            'title' => 'ID',
        ],

        'book_title'  => [
            'title'         => 'Book Title',
            'relationship'  => 'book',
            'select'        => '(:table).title',
        ],

        'price' => [
            'title'     => 'Price',
            'output'    => function($value) {
                return '$'.\App\Helpers\Price::convertIntegerToDecimal($value);
            }
        ],

        'html_images'   => [
            'title' => 'Images',
        ],

        'accept_trade_in_in_string'   => [
            'title' => 'Accept Trade-in',
        ],

        'trade_in_price'    => [
            'title'     => 'Trade-in Price',
            'output'    => function($value) {
                if ($value > 0) {
                    return '$'.$value;
                }

                return 'N/A';
            }
        ],

        'payout_method' => [
            'title' => 'Payout Method',
        ],

        'verified_in_string'  => [
            'title' => 'Verified',
        ],

        'sold_in_string'  => [
            'title' => 'Sold',
        ],

        'rejected_in_string'    => [
            'title' => 'Rejected',
        ],

        'seller'    => [
            'title' => 'Seller',
            'relationship'  => 'seller',
            'select'        => "CONCAT((:table).first_name, ' ', (:table).last_name)",
        ],

        'available_at'  => [
            'title' => 'Available At',
        ],

        'created_at'    => [
            'title' => 'Created At'
        ],

    ],

    'edit_fields'   => [

//        'price' => [
//            'title'         => 'Price',
//            'type'          => 'number',
//            'description'   => 'In cents, e.g., $15.00 = ¢1500',
//        ],

        'trade_in_price'    => [
            'title'         => 'Trade-In Price',
            'type'          => 'number',
//            'description'   => 'To approve trade-in, update the Trade-In Price, click Save and click Approve Trade-In.',
            'symbol'        => '$',
            'decimals'      => 2
        ],

        'verified'    => [
            'title' => 'Verified',
            'type'  => 'bool',
        ],

        'rejected_reason'   => [
            'title' => 'Reason for Trade-In Rejection',
            'type'  => 'textarea',
        ]

    ],

    'filters'   => [
        'id'    => [
            'type'  => 'key',
            'title' => 'ID'
        ],

        'book'  => [
            'type'          => 'relationship',
            'title'         => 'Book',
            'name_field'    => 'title'
        ],

//        'price' => [
//            'type'          => 'number',
//            'title'         => 'Price',
//            'description'   => 'The price in cents',
//            'symbol'        => '$',
//            'decimals'      => 0,
//            'min_value'     => 100
//        ],

        'accept_trade_in'   => [
            'type'  => 'bool',
            'title' => 'Accept Trade In'
        ],

        'payout_method' => [
            'type'      => 'enum',
            'title'     => 'Payout Method',
            'options'   => ['paypal', 'cash']
        ],

        'verified'  => [
            'type'  => 'bool',
            'title' => 'Verified'
        ],

        'sold'  => [
            'type'  => 'bool',
            'title' => 'Sold'
        ],

        'is_rejected'  => [
            'type'  => 'bool',
            'title' => 'Rejected'
        ],

        'created_at'    => [
            'type'  => 'datetime',
            'title' => 'Created At',
        ],
    ],

    'actions'   => [

        'approve_trade_in'  => [

            'title'     => 'Approve Trade-In',

            'messages'  => [
                'active'    => 'Approving...',
                'success'   => 'Trade-In approved successfully!',
                'error'     => 'There was an error while approving the trade-in.'
            ],

            'action'        => function(&$product)
            {
                if ($product->trade_in_price == 0 || $product->trade_in_price == null)
                {
                    return 'Please update the trade-in price first.';
                }

                if ($product->is_rejected)
                {
                    $product->update([
                        'is_rejected'       => false,
                        'rejected_reason'   => ''
                    ]);
                }

                $seller_order = \App\SellerOrder::where('product_id', '=', $product->id)->first();

                // check if seller order already exists
                if (!$seller_order)
                {
                    // create a seller order directly (without creating a buyer order)
                    // so the book now can be picked up
                    $seller_order = \App\SellerOrder::create([
                        'product_id'    => $product->id
                    ]);
                }

                event(new \App\Events\ProductWasUpdatedPriceAndApproved($seller_order));

                return true;
            }
        ],

        'reject_trade_in'  => [

            'title'     => 'Reject Trade-In',

            'messages'  => [
                'active'    => 'Rejecting...',
                'success'   => 'Trade-In rejected successfully!',
                'error'     => 'There was an error while rejecting the trade-in.'
            ],

            'action'        => function(&$product)
            {
                if ($product->is_rejected)
                {
                    return 'Already rejected.';
                }

                if (!$product->rejected_reason || $product->rejected_reason == '')
                {
                    return 'You need to provide a reason for rejection first.';
                }

                $product->update([
                    'is_rejected'       => true,
                    'trade_in_price'    => null
                ]);

                event(new \App\Events\ProductWasRejected($product));

                return true;
            }
        ]

    ]
];