<?php

use Illuminate\Database\Seeder;
use App\Book;
use App\BookBinding;
use App\BookLanguage;

class BookTableSeeder extends Seeder {

public function run()
{
    DB::table('books')->delete();

    Book::create([
        'title'     => 'Principles of solid mechanics',
        'author'    => 'Richards, Rowland',
        'edition'   => 1,
        'isbn'      => '9780849303159',
        'num_pages' => 446
    ]);

    Book::create([
        'title'     => 'Algorithms',
        'author'    => 'Robert Sedgewick, Kevin Wayne',
        'edition'   => 4,
        'isbn'      => '9780321573513',
        'num_pages' => 992
    ]);

    Book::create([
        'title'     => 'Programming Problems: Advanced Algorithms (Volume 2)',
        'author'    => 'Bradley Green',
        'edition'   => 1,
        'isbn'      => '9781484964095',
        'num_pages' => 200
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
