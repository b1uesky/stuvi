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
                'title' => 'ISBN'
            ),
            'edition' => array(
                'title' => 'Edition'
            ),
            'image' => array(
                'title' => 'Image',
                'relationship' => 'imageSet',
                'select' => '(:table).medium_image',
                'output' => '<img src="(:value)" />'
            ),
            'binding' => array(
                'title' => 'Binding'
            ),
            'language' => array(
                'title' => 'Language'
            ),
            'num_pages' => array(
                'title' => 'Number of Pages'
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
            'title' => array(
                'title' => 'Title',
                'type' => 'text'
            ),
            'isbn' => array(
                'title' => 'ISBN',
                'type' => 'number'
            ),
            'edition' => array(
                'title' => 'Edition',
                'type' => 'number'
            ),
            'binding' => array(
                'title' => 'Binding',
                'type'  => 'text'
            ),
            'language' => array(
                'title' => 'Language',
                'type'  => 'text'
            ),
            'num_pages' => array(
                'title' => 'Number of Pages',
                'type' => 'number'
            ),
            'verified' => array(
                'title' => 'Verified',
                'type' => 'bool'
            ),
        ),
    );
