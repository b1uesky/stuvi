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

        'html_images'   => [
            'title' => 'Images',
        ],

        'price' => [
            'title'     => 'Price',
            'output'    => function($value) {
                return '$'.\App\Helpers\Price::convertIntegerToDecimal($value);
            }
        ],

        'general_condition' => [
            'title'         => 'General Condition',
            'relationship'  => 'condition',
            'select'        => '(:table).general_condition',
            'output'        => function($value) {
                return config('product.conditions.general_condition')[$value];
            }
        ],

        'highlights_and_notes' => [
            'title'     => 'Highlights / Notes',
            'relationship'  => 'condition',
            'select'        => '(:table).highlights_and_notes',
            'output'        => function($value) {
                return config('product.conditions.highlights_and_notes')[$value];
            }
        ],

        'damaged_pages' => [
            'title'     => 'Damaged Pages',
            'relationship'  => 'condition',
            'select'        => '(:table).damaged_pages',
            'output'        => function($value) {
                return config('product.conditions.damaged_pages')[$value];
            }
        ],

        'broken_binding' => [
            'title'     => 'Broken Binding',
            'relationship'  => 'condition',
            'select'        => '(:table).broken_binding',
            'output'        => function($value) {
                return config('product.conditions.broken_binding')[$value];
            }
        ],

        'accept_trade_in_in_string'   => [
            'title' => 'Accept Trade-in',
        ],

//        'trade_in_price'    => [
//            'title'     => 'Trade-in Price',
//            'output'    => function($value) {
//                if ($value > 0) {
//                    return '$'.$value;
//                }
//
//                return 'N/A';
//            }
//        ],

        'payout_method' => [
            'title' => 'Payout Method',
        ],

//        'verified_in_string'  => [
//            'title' => 'Verified',
//        ],

        'sold_in_string'  => [
            'title' => 'Sold',
        ],

//        'rejected_in_string'    => [
//            'title' => 'Rejected',
//        ],

        'seller'    => [
            'title' => 'Seller',
            'relationship'  => 'seller',
            'select'        => "CONCAT((:table).first_name, ' ', (:table).last_name)",
        ],

//        'available_at'  => [
//            'title' => 'Available At',
//        ],

        'created_at'    => [
            'title' => 'Created At'
        ],

    ],

    'edit_fields'   => [

        'trade_in_price'    => [
            'title'         => 'Trade-In Price',
            'type'          => 'number',
            'description'   => 'To approve trade-in, update the Trade-In Price, click Save. Then, click Approve Trade-In.',
//            'symbol'        => '$',
            'decimals'      => 2
        ],

        'verified'    => [
            'title' => 'Verified',
            'type'  => 'bool',
        ],

        'rejected_reason'   => [
            'title' => 'Trade-In Rejection Reason',
            'description'   => 'To reject trade-in, update the reason for rejection, click Save. Then, click Reject Trade-In.',
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

        'seller'    => [
            'type'          => 'relationship',
            'title'         => 'Seller',
            'name_field'    => 'last_name'
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
                if (!$product->accept_trade_in)
                {
                    return 'Error: This book does not accept trade-in.';
                }

                if ($product->trade_in_price == 0 || $product->trade_in_price == null)
                {
                    return 'Error: Please update the trade-in price first.';
                }

                if ($product->sold)
                {
                    return 'Error: This book has been sold.';
                }

                if ($product->is_rejected)
                {
                    $product->update([
                        'is_rejected'       => false,
                        'rejected_reason'   => ''
                    ]);
                }

                // need to cancel old trade-in offers
                $old_trade_in_orders = \App\SellerOrder::where('product_id', $product->id)
                    ->whereNull('buyer_order_id')
                    ->get();

                if ($old_trade_in_orders)
                {
                    foreach ($old_trade_in_orders as $order)
                    {
                        if ($order->isCancellable())
                        {
                            $order->update([
                                'cancelled'         => true,
                                'cancelled_time'    => \Carbon\Carbon::now(),
                                'cancelled_by'      => Auth::id(),
                                'cancel_reason'     => 'A new trade-in offer has been created.'
                            ]);
                        }
                    }
                }

                // create a new seller order without creating a buyer order
                // so the book now can be picked up
                $seller_order = \App\SellerOrder::create([
                    'product_id'    => $product->id
                ]);

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
                if ($product->sold)
                {
                    return 'Error: This book has been sold.';
                }

                if ($product->is_rejected)
                {
                    return 'Error: Already rejected.';
                }

                if (!$product->rejected_reason || $product->rejected_reason == '')
                {
                    return 'Error: You need to provide a reason for rejection first.';
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