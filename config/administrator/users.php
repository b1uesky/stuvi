<?php

return [
    'title'     => 'Users',
    'single'    => 'user',
    'model'     => 'App\User',

    'columns'   => [

        'id'    => [
            'title' => 'ID',
        ],

        'primary_email_address' => [
            'title'         => 'Primary Email Address',
            'relationship'  => 'primaryEmail',
            'select'        => '(:table).email_address',
        ],

        'first_name' => [
            'title' => 'First Name',
        ],

        'last_name' => [
            'title' => 'Last Name',
        ],

        'university' => [
            'title'         => 'University',
            'relationship'  => 'university',
            'select'        => '(:table).abbreviation'
        ],

        'phone_number'  => [
            'title' => 'Phone Number',
        ],

        'role'  => [
            'title' => 'Role'
        ],

    ],

    'edit_fields'   => [

        'first_name'    => [
            'title' => 'First Name',
            'type'  => 'text',
        ],

        'last_name' => [
            'title' => 'Last Name',
            'type'  => 'text',
        ],

        'phone_number'  => [
            'title' => 'Phone Number',
            'type'  => 'text',
        ],

        'role'  => [
            'title' => 'Role',
            'type'  => 'text',
        ]

    ]
];