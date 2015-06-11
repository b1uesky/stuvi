<?php

    return array(
        /**
         * Model title
         *
         * @type string
         */
        'title' => 'Book Image Sets',

        /**
         * The singular name of your model
         *
         * @type string
         */
        'single' => 'book_image_set',

        /**
         * The class name of the Eloquent model that this config represents
         *
         * @type string
         */
        'model' => 'App\BookImageSet',

        /**
         * The columns array
         *
         * @type array
         */
        'columns' => array(
            'book_id' => array(
                'title' => 'Book ID'
            ),
            'small_image' => array(
                'title' => 'Small Image',
                'output' => '<img src="(:value)" />'
            ),
            'medium_image' => array(
                'title' => 'Medium Image',
                'output' => '<img src="(:value)" />'
            ),
            'large_image' => array(
                'title' => 'Large Image',
                'output' => '<img src="(:value)" height="300px" />'
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
                'type'  => 'text'
            ),
        ),
    );
