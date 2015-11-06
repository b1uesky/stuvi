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
            'title' =>  'General condition',
            'count' =>  3,
            0       =>  'Like new',
            1       =>  'Good',
            2       =>  'Acceptable',
            'description'   => [
                0   =>  'No missing or damaged pages, no creases or tears, and no underlining/highlighting of text or writing in the margins. Very minimal wear and tear.',
                1   =>  'The majority of pages are undamaged with minimal creasing or tearing. Minimal underlining or highlighting. No missing pages.',
                2   =>  'A book with obvious wear. Possible writing in margins, possible underlining and highlighting of text, but no missing pages or anything that would compromise the legibility or understanding of the text.'
            ]
        ],

        'highlights_and_notes'      =>  [
            'title' =>  'Highlights/Notes',
            0 => '0 - 5 pages',
            1 => '6 - 15 pages',
            2 => '> 15 pages',
            'description' => 'The approximate number of pages that contain highlighted/underlined material or notes.',
        ],

        'damaged_pages'             =>  [
            'title' =>  'Damaged pages',
            0       =>  '0',
            1       => '1 - 3 pages',
            2       =>  '> 3 pages',
            'description' => 'The approximate number of damaged pages. This includes folded pages, partially torn pages, and water damage.',
        ],

        'broken_binding'            =>  [
            'title' =>  'Broken binding',
            0       =>  'No',
            1       =>  'Yes',
            'description' => 'The book binding is severely damaged or not.',
        ],

        'description'               =>  [
            'title' =>  'Additional description',
            'placeholder'   =>  '(Optional) More description on your book conditions.'
        ],
    ],
];