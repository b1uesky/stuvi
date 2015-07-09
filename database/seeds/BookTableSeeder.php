<?php

use Illuminate\Database\Seeder;
use App\Book;
use App\BookAuthor;
use App\BookImageSet;
use App\Helpers\AmazonLookUp;

use Illuminate\Config\Repository;

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
    ];

    foreach($isbns as $isbn)
    {
        $amazon = new AmazonLookUp($isbn, 'ISBN');

        if ($amazon->success())
        {
//            $amazon->saveToXML();

            // save this book to our database
            $book = new Book();
            $book->isbn10               = $amazon->getISBN10();
            $book->isbn13               = $amazon->getISBN13();
            $book->title                = $amazon->getTitle();
            $book->edition              = $amazon->getEdition();
            $book->binding              = $amazon->getBinding();
            $book->language             = $amazon->getLanguage();
            $book->num_pages            = $amazon->getNumPages();
            $book->list_price           = $amazon->getListPriceDecimalPrice();
            $book->lowest_new_price     = $amazon->getLowestNewPriceDecimalPrice();
            $book->lowest_used_price    = $amazon->getLowestUsedriceDecimalPrice();
            $book->save();

            // save book image set
            $book_image_set                 = new BookImageSet();
            $book_image_set->book_id        = $book->id;
            $book_image_set->small_image    = $amazon->getSmallImage();
            $book_image_set->medium_image   = $amazon->getMediumImage();
            $book_image_set->large_image    = $amazon->getLargeImage();
            $book_image_set->save();

//            var_dump($amazon->saveToXML());
            // save book authors
            foreach ($amazon->getAuthors() as $author_name) {
                $book_author            = new BookAuthor();
                $book_author->book_id   = $book->id;
                $book_author->full_name = $author_name;
                $book_author->save();
            }
        }
    }
}

}
