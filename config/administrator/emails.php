<?php

return [
    'title'     => 'Emails',
    'single'    => 'email',
    'model'     => 'App\Email',

    'columns'   => [

        'id'    => [
            'title' => 'ID',
        ],

        'email_address' => [
            'title' => 'Email Address',
        ],

        'user'   => [
            'title'         => 'User',
            'relationship'  => 'user',
            'select'        => "CONCAT((:table).first_name, ' ', (:table).last_name)",
        ],

        'verified'  => [
            'title' => 'Verified'
        ]
    ],

    'edit_fields'   => [

        'email_address' => [
            'title' => 'Email Address'
        ]

    ]
];