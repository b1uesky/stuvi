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
            },
            'visible'   => function($model) {
                return ($model->trade_in_price > 0);
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
//            'title' => 'Price',
//            'type'  => 'number',
//            'symbol'    => '$',
//            'decimals'  => 2,
//        ],

        'verified'    => [
            'title' => 'Verified',
            'type'  => 'bool',
        ],

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
    ]
];