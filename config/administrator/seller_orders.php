<?php

return [
    'title'     => 'Seller Orders',
    'single'    => 'seller_order',
    'model'     => 'App\SellerOrder',

    'columns'   => [

        'id'    => [
            'title' => 'ID',
        ],

        'buyer_order_id'    => [
            'title' => 'Buyer Order ID'
        ],

        'product_id'    => [
            'title' => 'Product ID'
        ],

        'book_title'  => [
            'title'         => 'Book Title',
            'relationship'  => 'product.book',
            'select'        => '(:table).title',
        ],

        'seller_name'  => [
            'title'         => 'Seller',
            'relationship'  => 'product.seller',
            'select'        => "CONCAT((:table).first_name, ' ', (:table).last_name)",
        ],

        // need better format
        'address_id'   => [
            'title' => 'Pickup Address',
            'relationship'  => 'address',
            'select'        => '(:table).address_line1'
        ],

        'scheduled_pickup_time'   => [
            'title'     => 'Scheduled Pickup Time'
        ],

        'pickup_time'    => [
            'title'     => 'Pickup Time'
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
        ],

        'buyerOrder'    => [
            'type'          => 'relationship',
            'title'         => 'Buyer Order ID',
            'name_field'    => 'id'
        ],

        'product'   => [
            'type'          => 'relationship',
            'title'         => 'Product ID',
            'name_field'    => 'id'
        ],
    ]
];