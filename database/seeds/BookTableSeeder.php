<?php

use Illuminate\Database\Seeder;
use App\Book;
use App\BookAuthor;
use App\BookImageSet;

class BookTableSeeder extends Seeder {

public function run()
{
    DB::table('book_authors')->delete();
    DB::table('book_image_sets')->delete();
    DB::table('books')->delete();

    $folder = '/img/book/';

    $mech = Book::create([
        'title'         => 'Principles of solid mechanics',
        'edition'       => 1,
        'isbn'          => '9780849303159',
        'num_pages'     => 446,
        'binding_id'    => 1,
        'language_id'   => 1
    ]);

    $alg = Book::create([
        'title'         => 'Algorithms',
        'edition'       => 4,
        'isbn'          => '9780321573513',
        'num_pages'     => 992,
        'binding_id'    => 2,
        'language_id'   => 1
    ]);

    $pp = Book::create([
        'title'         => 'Programming Problems: Advanced Algorithms (Volume 2)',
        'edition'       => 1,
        'isbn'          => '9781484964095',
        'num_pages'     => 200,
        'binding_id'    => 2,
        'language_id'   => 1
    ]);

    BookAuthor::create([
        'book_id'       => $mech->id,
        'full_name'     => 'Richards Rowland'
        ]);

    BookAuthor::create([
        'book_id'       => $alg->id,
        'full_name'     => 'Robert Sedgewick'
        ]);

    BookAuthor::create([
        'book_id'       => $alg->id,
        'full_name'     => 'Kevin Wayne'
        ]);

    BookAuthor::create([
        'book_id'       => $pp->id,
        'full_name'     => 'Bradley Green'
        ]);

    BookImageSet::create([
        'book_id'       => $mech->id,
        'large_image'   => $folder . 'Principles-of-solid-mechanics.jpg'
        ]);

    BookImageSet::create([
        'book_id'       => $alg->id,
        'large_image'   => $folder . 'Algorithms.png'
        ]);

    BookImageSet::create([
        'book_id'       => $pp->id,
        'large_image'   => $folder . 'Programming-Problems.jpg'
        ]);
}

}
