<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SearchTest extends TestCase
{
    use DatabaseTransactions;

    public function testAutocompleteSearchWithEmptyTerm()
    {
        $response = $this->call('GET', 'textbook/searchAutoComplete?term=');

        $this->assertEquals(200, $response->status());
    }

    public function testAutocompleteSearchWithAlg()
    {
        $response = $this->call('GET', 'textbook/searchAutoComplete?term=alg');

        $this->assertEquals(200, $response->status());
    }
}
