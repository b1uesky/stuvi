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

        'available_at'  => [
            'title' => 'Available At',
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

        'html_images'   => [
            'title' => 'Images',
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

    ]
];