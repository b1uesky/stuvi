<?php

    return array(
        /**
         * Model title
         *
         * @type string
         */
        'title' => 'Books',

        /**
         * The singular name of your model
         *
         * @type string
         */
        'single' => 'book',

        /**
         * The class name of the Eloquent model that this config represents
         *
         * @type string
         */
        'model' => 'App\Book',

        /**
         * The columns array
         *
         * @type array
         */
        'columns' => array(
            'title' => array(
                'title' => 'Title'
            ),
            'isbn' => array(
                'isbn' => 'ISBN'
            ),
            'edition' => array(
                'edition' => 'Edition'
            ),
            'author' => array(
                'author' => 'Author'
            ),
            'num_pages' => array(
                'num_pages' => 'Number of Pages'
            ),
            'verified' => array(
                'verified' => 'Verified'
            ),
            'binding_id' => array(
                'binding_id' => 'Binding ID'
            ),
            'image_set_id' => array(
                'image_set_id' => 'Image Set ID'
            ),
            'language_id' => array(
                'language_id' => 'Language ID'
            ),
            'amazon_info_id' => array(
                'amazon_info_id' => 'Amazon Info ID'
            ),
        ),

        /**
         * The edit fields array
         *
         * @type array
         */
        'edit_fields' => array(
            'title' => array(
                'title' => 'Title',
                'type' => 'text',
            ),
            'isbn' => array(
                'isbn' => 'ISBN',
                'type' => 'number',
            ),
            'edition' => array(
                'edition' => 'Edition',
                'type' => 'number',
            ),
            'author' => array(
                'author' => 'Author',
                'type' => 'text',
            ),
            'num_pages' => array(
                'num_pages' => 'Number of Pages',
                'type' => 'number',
            ),
            'verified' => array(
                'verified' => 'Verified',
                'type' => 'bool',
            ),
            'binding_id' => array(
                'binding_id' => 'Binding ID',
                'type' => 'number',
            ),
            'image_set_id' => array(
                'image_set_id' => 'Image Set ID',
                'type' => 'number',
            ),
            'language_id' => array(
                'language_id' => 'Language ID',
                'type' => 'number',
            ),
            'amazon_info_id' => array(
                'amazon_info_id' => 'Amazon Info ID',
                'type' => 'number',
            ),
        ),
    );
