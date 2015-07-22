<?php

use Illuminate\Database\Seeder;
use Illuminate\Config\Repository;

use App\Book;
use App\BookAuthor;
use App\BookImageSet;

use GoogleBooks\GoogleBooks;


class BookTableSeeder extends Seeder {

public function run()
{
    DB::table('book_authors')->delete();
    DB::table('book_image_sets')->delete();
    DB::table('books')->delete();

    $isbns = [
        '9780849303159',    // Principles of solid mechanics
        '9780321573513',    // Algorithms
        '9781484964095',    // Programming Problems: Advanced Algorithms (Volume 2)
        '098478280X',       // Cracking the Coding Interview
        '0262033844',       // Introduction to Algorithms
        '1479274836',       // Elements of Programming Interviews: The Insiders' Guide
        '1468108867',       // Data Structures and Algorithms Made Easy
        '1118261364',       // Programming Interviews Exposed: Secrets to Landing Your Next Job
        '9781501100079',    // Finders Keepers: A Novel
        '1476754470',       // Mr. Mercedes: A Novel
        '1451627297',       // 11/22/63: A Novel
        '1451698852',       // Doctor Sleep
        '0735611319',       // Code: The Hidden Language of Computer Hardware and Software
        '1449672841',       // Computer Science Illuminated, 5th Edition
        '0132569035',       // Computer Science: An Overview, 11/e
        '1593271441',       // Hacking: The Art of Exploitation, 2nd Edition
    ];

    $key = Config::get('services.google.books.api_key');

    foreach($isbns as $isbn)
    {
        $google_book = new GoogleBooks($key);

        if ($google_book->searchByISBN($isbn))
        {

            // save this book to our database
            $book = Book::create([
                'isbn10'    => $google_book->getIsbn10(),
                'isbn13'    => $google_book->getIsbn13(),
                'title'     => $google_book->getTitle(),
                'language'  => $google_book->getLanguage(),
                'num_pages' => $google_book->getPageCount(),
            ]);

            // save book image set
            BookImageSet::create([
                'book_id'       => $book->id,
                'small_image'   => $google_book->getSmallThumbnail()
            ]);

            // save book authors
            foreach ($google_book->getAuthors() as $author_name) {
                BookAuthor::create([
                    'book_id'   => $book->id,
                    'full_name' => $author_name
                ]);
            }
        }
    }
}

}
