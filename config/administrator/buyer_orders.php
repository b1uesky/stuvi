<?php

return [
    'title'     => 'Buyer Orders',
    'single'    => 'buyer_order',
    'model'     => 'App\BuyerOrder',

    'columns'   => [

        'id'    => [
            'title' => 'ID',
        ],

        'subtotal'  => [
            'title'     => 'Subtotal',
            'output'    => function($value) {
                return '$'.\App\Helpers\Price::convertIntegerToDecimal($value);
            }
        ],

        'tax'   => [
            'title'     => 'Tax',
            'output'    => function($value) {
                return '$'.\App\Helpers\Price::convertIntegerToDecimal($value);
            }
        ],

        'shipping'   => [
            'title'     => 'Shipping',
            'output'    => function($value) {
                return '$'.\App\Helpers\Price::convertIntegerToDecimal($value);
            }
        ],

        'discount'   => [
            'title'     => 'Discount',
            'output'    => function($value) {
                return '$'.\App\Helpers\Price::convertIntegerToDecimal($value);
            }
        ],

        'amount'   => [
            'title'     => 'Total',
            'output'    => function($value) {
                return '$'.\App\Helpers\Price::convertIntegerToDecimal($value);
            }
        ],

        'payment_method'    => [
            'title' => 'Payment Method'
        ],

        'buyer_id'  => [
            'title'         => 'Buyer',
            'relationship'  => 'buyer',
            'select'        => "CONCAT((:table).first_name, ' ', (:table).last_name)",
        ],

        // need better format
        'shipping_address_id'   => [
            'title' => 'Shipping Address',
            'relationship'  => 'shipping_address',
            'select'        => '(:table).address_line1'
        ],

        'scheduled_delivery_time'   => [
            'title'     => 'Scheduled Delivery Time'
        ],

        'time_delivered'    => [
            'title'     => 'Delivery Time'
        ],

        'courier_id'    => [
            'title'         => 'Courier',
            'relationship'  => 'courier',
            'select'        => "CONCAT((:table).first_name, ' ', (:table).last_name)",
        ],

        'cancelled_in_string' => [
            'title' => 'Cancelled',
        ],

        'created_at'    => [
            'title' => 'Created At'
        ],

    ],

    'edit_fields'   => [

        'cancelled'    => [
            'title' => 'Cancelled',
            'type'  => 'bool',
        ],

    ],

    'filters'   => [
        'id'    => [
            'type'  => 'key',
            'title' => 'ID'
        ]
    ]
];