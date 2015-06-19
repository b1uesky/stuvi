<?php
/**
 * Created by PhpStorm.
 * User: Desmond
 * Date: 6/17/15
 * Time: 12:15 PM
 */

return [
    'conditions' => [

        'general_condition'         =>  [
            'title' =>  'General Condition',
            0       =>  'Brand New',
            1       =>  'Excellent',
            2       =>  'Good',
            3       =>  'Acceptable'
        ],

        'highlights_and_notes'      =>  [
            'title' =>  'Highlights/Notes',
            0       =>  '0 ~ 10 places',
            1       =>  '11 ~ 30 places',
            2       =>  '> 30 places'
        ],

        'damaged_pages'             =>  [
            'title' =>  'Damaged Pages',
            0       =>  '0',
            1       =>  '1 ~ 3 pages',
            2       =>  '> 3 pages'
        ],

        'broken_binding'            =>  [
            'title' =>  'Broken book binding',
            0       =>  'No',
            1       =>  'Yes'
        ],

        'description'               =>  [
            'title' =>  'Description',
            'placeholder'   =>  'More description on your book conditions.'
        ],
    ],
];