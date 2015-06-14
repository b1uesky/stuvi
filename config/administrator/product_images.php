<?php

    return array(
        /**
         * Model title
         *
         * @type string
         */
        'title' => 'Product Images',

        /**
         * The singular name of your model
         *
         * @type string
         */
        'single' => 'product_image',

        /**
         * The class name of the Eloquent model that this config represents
         *
         * @type string
         */
        'model' => 'App\ProductImage',

        /**
         * The columns array
         *
         * @type array
         */
        'columns' => array(
            'product_id' => array(
                'title' => 'Product ID'
            ),
            'image' => array(
                'title' => 'Image'
            ),
        ),

        /**
         * The edit fields array
         *
         * @type array
         */
        'edit_fields' => array(
            'product_id' => array(
                'title' => 'Product ID',
                'type' => 'number'
            ),
        ),
    );
