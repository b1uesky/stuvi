<?php

return [
    'title'     => 'Books',
    'single'    => 'book',
    'model'     => 'App\Book',

    'columns'   => [

        'id'    => [
            'title' => 'ID',
        ],

        'image'    => [
            'title'         => 'Image',
            'relationship'  => 'imageSet',
            'select'        => '(:table).small_image',
            'output'        => '<img src="'.(app()->environment() == 'production' ? config('aws.url.stuvi-book-img') : config('aws.url.stuvi-test-book-img')).'(:value)"/>',
        ],

        'title' => [
            'title' => 'Title',
        ],

        'edition' => [
            'title' => 'Edition',
        ],

        'isbn10'    => [
            'title' => 'ISBN-10',
        ],

        'isbn13'    => [
            'title' => 'ISBN-13',
        ],

        'is_verified'  => [
            'title' => 'Verified',
            'output'    => function($value) {
                return $value ? 'Yes' : 'No';
            }
        ],

        'created_at'    => [
            'title' => 'Created At'
        ],

    ],

    'edit_fields'   => [

        'title' => [
            'title' => 'Title',
            'type'  => 'text',
        ],

        'edition' => [
            'title' => 'Edition',
            'type'  => 'number',
        ],

        'isbn10'    => [
            'title' => 'ISBN-10',
            'type'  => 'text',
        ],

        'isbn13'    => [
            'title' => 'ISBN-13',
            'type'  => 'text',
        ],

        'is_verified'    => [
            'title' => 'Verified',
            'type'  => 'bool',
        ],

    ],

    'filters'   => [
        'title' => [
            'type'  => 'text',
            'title' => 'Title',
        ],

        'edition'   => [
            'type'  => 'number',
            'title' => 'Edition'
        ],

        'isbn10'    => [
            'type'  => 'text',
            'title' => 'ISBN-10',
        ],

        'isbn13'    => [
            'type'  => 'text',
            'title' => 'ISBN-13'
        ],

        'is_verified'  => [
            'type'  => 'bool',
            'title' => 'Verified'
        ],

        'created_at'    => [
            'type'  => 'datetime',
            'title' => 'Created At',
        ],
    ]
];