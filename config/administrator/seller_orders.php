<?php

    return array(
        /**
         * Model title
         *
         * @type string
         */
        'title' => 'SellerOrders',

        /**
         * The singular name of your model
         *
         * @type string
         */
        'single' => 'seller_order',

        /**
         * The class name of the Eloquent model that this config represents
         *
         * @type string
         */
        'model' => 'App\SellerOrder',

        /**
         * The columns array
         *
         * @type array
         */
        'columns' => array(
            'product_id' => array(
                'product_id' => 'Product ID'
            ),
            'cancelled' => array(
                'cancelled' => 'Cancelled'
            ),
            'seller_payment_id' => array(
                'seller_payment_id' => 'Seller Payment ID'
            ),
            'scheduled_pickup_time' => array(
                'scheduled_pickup_time' => 'Scheduled Pickup Time'
            ),
            'pickup_time' => array(
                'pickup_time' => 'Pickup Time'
            ),
            'buyer_order_id' => array(
                'buyer_order_id' => 'Buyer Order ID'
            ),
            'created_at' => array(
                'created_at' => 'Created At'
            ),
            'updated_at' => array(
                'updated_at' => 'Updated At'
            ),
        ),

        /**
         * The edit fields array
         *
         * @type array
         */
        'edit_fields' => array(
            'product_id' => array(
                'product_id' => 'Product ID',
                'type' => 'number',
            ),
            'cancelled' => array(
                'cancelled' => 'Cancelled',
                'type' => 'bool',
            ),
            'seller_payment_id' => array(
                'seller_payment_id' => 'Seller Payment ID',
                'type' => 'number',
            ),
            'scheduled_pickup_time' => array(
                'scheduled_pickup_time' => 'Scheduled Pickup Time',
                'type' => 'datetime',
            ),
            'pickup_time' => array(
                'pickup_time' => 'Pickup Time',
                'type' => 'datetime',
            ),
            'buyer_order_id' => array(
                'buyer_order_id' => 'Buyer Order ID',
                'type' => 'number',
            ),
            'created_at' => array(
                'created_at' => 'Created At',
                'type' => 'datetime',
            ),
            'updated_at' => array(
                'updated_at' => 'Updated At',
                'type' => 'datetime',
            ),

        ),
    );
