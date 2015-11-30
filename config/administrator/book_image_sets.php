<?php

return [
    'title'     => 'Book Images',
    'single'    => 'book_image_set',
    'model'     => 'App\BookImageSet',

    'columns'   => [

        'id'    => [
            'title' => 'ID',
        ],

        'small_image' => [
            'title' => 'Small',
        ],

        'medium_image' => [
            'title' => 'Medium',
        ],

        'large_image'    => [
            'title' => 'Large',
        ],

    ],

    'edit_fields'   => [

        'small_image' => [
            'title' => 'Small',
            'type'  => 'text',
        ],

        'medium_image' => [
            'title' => 'Medium',
            'type'  => 'text',
        ],

        'large_image'    => [
            'title' => 'Large',
            'type'  => 'text',
        ],

    ],

    'filters'   => [
        'book'  => [
            'type'          => 'relationship',
            'title'         => 'Book',
            'name_field'    => 'title'
        ]
    ]
];