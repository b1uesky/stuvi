<?php

return [
    'title'     => 'Book Reminders',
    'single'    => 'book_reminder',
    'model'     => 'App\BookReminder',

    'columns'   => [

        'id'    => [
            'title' => 'ID',
        ],

        'book_title'  => [
            'title'         => 'Book Title',
            'relationship'  => 'book',
            'select'        => '(:table).title',
        ],

        'user_name'    => [
            'title' => 'User',
            'relationship'  => 'user',
            'select'        => "CONCAT((:table).first_name, ' ', (:table).last_name)",
        ],

        'email' => [
            'title' => 'Email',
            'relationship'  => 'user.primaryEmail',
            'select'        => "(:table).email_address",
        ]

    ],

    'edit_fields'   => [

        'created_at' => [
            'title' => 'Created At',
            'type'  => 'datetime',
        ],

    ],

    'filters'   => [
        'book'  => [
            'type'          => 'relationship',
            'title'         => 'Book',
            'name_field'    => 'title'
        ],

        'user'  => [
            'type'          => 'relationship',
            'title'         => 'User',
            'name_field'    => 'first_name'
        ]
    ]
];