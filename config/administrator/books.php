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
            'publisher' => array(
                'publisher' => 'Publisher'
            ),
            'publication_date' => array(
                'publication_date' => 'Publication Date'
            ),
            'manufacturer' => array(
                'manufacturer' => 'Manufacturer'
            ),
            'num_pages' => array(
                'num_pages' => 'Number of Pages'
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
            'publisher' => array(
                'publisher' => 'Publisher',
                'type' => 'text',
            ),
            'publication_date' => array(
                'publication_date' => 'Publication Date',
                'type' => 'date',
            ),
            'manufacturer' => array(
                'manufacturer' => 'Manufacturer',
                'type' => 'text',
            ),
            'num_pages' => array(
                'num_pages' => 'Number of Pages',
                'type' => 'number',
            ),
        ),
    );