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
            3       =>  'Acceptable',
            'description'   => [
                0   =>  'A new, unread, unused book in perfect condition with no missing or damaged pages.',
                1   =>  'No missing or damaged pages, no creases or tears, and no underlining/highlighting of text or writing in the margins. Very minimal wear and tear.',
                2   =>  'Very minimal damage to the cover, but no holes or tears. The majority of pages are undamaged with minimal creasing or tearing. Minimal underlining or highlighting. No missing pages.',
                3   =>  'A book with obvious wear. The binding may be slightly damaged but not broken. Possible writing in margins, possible underlining and highlighting of text, but no missing pages or anything that would compromise the legibility or understanding of the text.'
            ]
        ],

        'highlights_and_notes'      =>  [
            'title' =>  'Highlights/Notes',
            0 => '0 - 5 pages',
            1 => '6 - 15 pages',
            2 => '> 15 pages',
            'description'   =>  'Please select the approximate number of pages that contain highlighted/underlined material or notes.'
        ],

        'damaged_pages'             =>  [
            'title' =>  'Damaged Pages',
            0       =>  '0',
            1 => '1 - 3 pages',
            2       =>  '> 3 pages',
            'description'   =>  'Please select the approximate number of damaged pages. This includes folded or partially torn pages and water damage.'
        ],

        'broken_binding'            =>  [
            'title' =>  'Broken book binding',
            0       =>  'No',
            1       =>  'Yes',
            'description'   =>  'Please select "Yes" if the binding is severely damaged or completely broken. Please note that the buyer will be warned about this book\'s poor condition and will likely not be willing to pay full price for this book.'
        ],

        'description'               =>  [
            'title' =>  'Description',
            'placeholder'   =>  'More description on your book conditions.'
        ],
    ],
];