<?php

return [
    'title'     => 'Universities',
    'single'    => 'university',
    'model'     => 'App\University',

    'columns'   => [

        'id'    => [
            'title' => 'ID',
        ],

        'name'  => [
            'title' => 'Name'
        ],

        'abbreviation'  => [
            'title' => 'Abbreviation'
        ],

        'email_suffix'  => [
            'title' => 'Email Suffix'
        ],

        'is_public' => [
            'title'     => 'Public',
            'output'    => function($value) {
                return $value ? 'Yes' : 'No';
            }
        ]
    ],

    'edit_fields'   => [

        'name'    => [
            'title' => 'Name',
            'type'  => 'text',
        ],

        'abbreviation'  => [
            'title' => 'Abbreviation',
            'type'  =>  'text'
        ],

        'email_suffix'  => [
            'title' => 'Email Suffix',
            'type'  => 'text'
        ],

        'is_public' => [
            'title' => 'Public',
            'type'  => 'bool'
        ]
    ]
];