<?php

    return array(
        /**
         * Model title
         *
         * @type string
         */
        'title' => 'Products',

        /**
         * The singular name of your model
         *
         * @type string
         */
        'single' => 'product',

        /**
         * The class name of the Eloquent model that this config represents
         *
         * @type string
         */
        'model' => 'App\Product',

        /**
         * The columns array
         *
         * @type array
         */
        'columns' => array(
            'book_title' => array(
                'title' => 'Book Title',
                'relationship' => 'book',
                'select' => '(:table).title'
            ),
            'book_id' => array(
                'title' => 'Book ID'
            ),
            'seller_id' => array(
                'title' => 'Seller ID'
            ),
            'price' => array(
                'title' => 'Price'
            ),
            'sold' => array(
                'title' => 'Sold'
            ),
            'verified' => array(
                'title' => 'Verified'
            ),
        ),

        /**
         * The edit fields array
         *
         * @type array
         */
        'edit_fields' => array(
            'book_id' => array(
                'title' => 'Book ID',
                'type' => 'number'
            ),
            'seller_id' => array(
                'title' => 'Seller ID',
                'type' => 'number'
            ),
            'price' => array(
                'title' => 'Price',
                'type' => 'number',
                'decimals' => '2',
                'symbol' => '$'
            ),
            'sold' => array(
                'title' => 'Sold',
                'type' => 'bool'
            ),
            'verified' => array(
                'title' => 'Verified',
                'type' => 'bool'
            ),
        ),
    );
