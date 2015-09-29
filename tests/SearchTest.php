<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SearchTest extends TestCase
{
    use DatabaseTransactions;

    public function testBuySearchWithEmptyInput()
    {
        $this->visit('/textbook/buy')
            ->select(1, 'university_id')
            ->press('Search')
            ->seePageIs('/textbook/buy/search?query=&university_id=1');
    }

    public function testBuySearchWithInputAlg()
    {
        $this->visit('/textbook/buy')
            ->type('alg', 'query')
            ->select(1, 'university_id')
            ->press('Search')
            ->seePageIs('/textbook/buy/search?query=alg&university_id=1');
    }

    public function testSellSearchWithExistingISBN()
    {
        $isbn = '032157351X';
        $book = App\Book::where('isbn10', $isbn)->first();

        $this->visit('/textbook/sell')
            ->type($isbn, 'isbn')
            ->press('Search')
            ->seePageIs('/textbook/sell/product/' . $book->id . '/confirm');
    }

    public function testSellSearchWithNonExistingISBN()
    {
        $isbn = '0321842685';

        $this->visit('/textbook/sell')
            ->type($isbn, 'isbn')
            ->press('Search')
            ->seeInDatabase('books', ['isbn10' => '0321842685'])
            ->seePageIs('/textbook/sell/product/' . App\Book::where('isbn10', $isbn)->first()->id . '/confirm');
    }

    public function testAutocompleteSearchWithEmptyTerm()
    {
        $response = $this->call('GET', 'textbook/searchAutoComplete?term=&university_id=1');

        $this->assertEquals(200, $response->status());
    }

    public function testAutocompleteSearchWithAlg()
    {
        $response = $this->call('GET', 'textbook/searchAutoComplete?term=alg&university_id=1');

        $this->assertEquals(200, $response->status());
    }
}
