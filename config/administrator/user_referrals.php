<?php

return [
    'title'     => 'User Referrals',
    'single'    => 'user_referral',
    'model'     => 'App\UserReferral',

    'columns'   => [

        'id'    => [
            'title' => 'ID',
        ],

        'user_id'   => [
            'title' => 'User ID',
        ],

        'reference_user_id' => [
            'title' => 'Reference user ID',
        ],

        'reference_email'   => [
            'title' => 'Reference email',
        ],

        'created_at'    => [
            'title' => 'Created At'
        ],

    ],

    'edit_fields'   => [

        'reference_email'    => [
            'title' => 'Reference Email',
            'type'  => 'text',
            'editable'  => false,
        ],
    ],

    'filters'   => [
    ]
];