<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SearchTest extends TestCase
{
    use DatabaseTransactions;

    public function test_search_with_empty_input()
    {
        $this->visit('/')
            ->type('', 'query')
            ->press('Search')
            ->seePageIs('textbook/search?query=');
    }

    public function test_search_with_isbn10()
    {
        $faker = \Faker\Factory::create();
        $isbn10 = $faker->isbn10;

        $this->visit('/')
            ->type($isbn10, 'query')
            ->press('Search')
            ->seePageIs('textbook/search?query='.$isbn10);
    }

    public function test_search_with_isbn13()
    {
        $faker = \Faker\Factory::create();
        $isbn13 = $faker->isbn13;

        $this->visit('/')
            ->type($isbn13, 'query')
            ->press('Search')
            ->seePageIs('textbook/search?query='.$isbn13);
    }

    public function test_search_with_existing_isbn()
    {
        $isbn = \App\Book::orderByRaw('RAND()')->first()->isbn10;

        $this->visit('/')
            ->type($isbn, 'query')
            ->press('Search')
            ->seePageIs('textbook/search?query='.$isbn);
    }

    public function test_autocomplete_search_with_empty_term()
    {
        $response = $this->call('GET', 'textbook/searchAutoComplete?term=');

        $this->assertEquals(200, $response->status());
    }

    public function test_autocomplete_search_with_alg()
    {
        $response = $this->call('GET', 'textbook/searchAutoComplete?term=alg');

        $this->assertEquals(200, $response->status());
    }
}
