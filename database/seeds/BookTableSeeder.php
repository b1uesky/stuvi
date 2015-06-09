<?php

use Illuminate\Database\Seeder;
use App\Book;
use App\BookBinding;
use App\BookLanguage;
use App\BookImageSet;

class BookTableSeeder extends Seeder {

public function run()
{
    DB::table('book_image_sets')->delete();
    DB::table('books')->delete();

    $folder = '/img/book/';

    $mechanics_image_sets = BookImageSet::create([
        'large_image'   => $folder . 'Principles-of-solid-mechanics.jpg'
        ]);

    $algorithms_image_sets = BookImageSet::create([
        'large_image'   => $folder . 'Algorithms.png'
        ]);

    $pp_image_sets = BookImageSet::create([
        'large_image'   => $folder . 'Programming-Problems.jpg'
        ]);

    Book::create([
        'title'     => 'Principles of solid mechanics',
        'author'    => 'Richards, Rowland',
        'edition'   => 1,
        'isbn'      => '9780849303159',
        'num_pages' => 446,
        'image_set_id'  => $mechanics_image_sets->id
    ]);

    Book::create([
        'title'     => 'Algorithms',
        'author'    => 'Robert Sedgewick, Kevin Wayne',
        'edition'   => 4,
        'isbn'      => '9780321573513',
        'num_pages' => 992,
        'image_set_id'  => $algorithms_image_sets->id
    ]);

    Book::create([
        'title'     => 'Programming Problems: Advanced Algorithms (Volume 2)',
        'author'    => 'Bradley Green',
        'edition'   => 1,
        'isbn'      => '9781484964095',
        'num_pages' => 200,
        'image_set_id'  => $pp_image_sets->id
    ]);

    BookBinding::create([
        'binding'   => 'hard'
    ]);

    BookBinding::create([
        'binding'   => 'soft'
    ]);

    BookLanguage::create([
        'language'  => 'English'
    ]);

    BookLanguage::create([
        'language'  => 'Spanish'
    ]);

    BookLanguage::create([
        'language'  => 'Chinese'
    ]);
}

}
