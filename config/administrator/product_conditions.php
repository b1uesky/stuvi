<?php

return [
    'title'     => 'Product Conditions',
    'single'    => 'product_condition',
    'model'     => 'App\ProductCondition',

    'columns'   => [

        'id'    => [
            'title' => 'ID',
        ],

        'product_id'    => [
            'title' => 'Product ID',
        ],

        'general_condition' => [
            'title'     => 'General Condition',
            'output'    => function($value) {
                return config('product.conditions.general_condition')[$value];
            }
        ],

        'highlights_and_notes' => [
            'title'     => 'Highlights / Notes',
            'output'    => function($value) {
                return config('product.conditions.highlights_and_notes')[$value];
            }
        ],

        'damaged_pages' => [
            'title'     => 'Damaged Pages',
            'output'    => function($value) {
                return config('product.conditions.damaged_pages')[$value];
            }
        ],

        'broken_binding' => [
            'title'     => 'Broken Binding',
            'output'    => function($value) {
                return config('product.conditions.broken_binding')[$value];
            }
        ],

    ],

    'edit_fields'   => [
        'general_condition' => [
            'title'     => 'General Condition',
            'type'      => 'number'
        ],

        'highlights_and_notes' => [
            'title'     => 'Highlights / Notes',
            'type'      => 'number'
        ],

        'damaged_pages' => [
            'title'     => 'Damaged Pages',
            'type'      => 'number'
        ],

        'broken_binding' => [
            'title'     => 'Broken Binding',
            'type'      => 'bool'
        ],
    ],

    'filters'   => [

    ],
];