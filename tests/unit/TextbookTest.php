<?php


class TextbookTest extends \Codeception\TestCase\Test
{
    /**
     * @var \UnitTester
     */
    protected $tester;


    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function test_adding_price()
    {
        $book = factory(\App\Book::class)->create();
        $faker = \Faker\Factory::create();

        // currently this book does not have lowest and highest price
        // so adding a price will update lowest_price and
        // highest_price to the same price
        $price1 = $faker->randomFloat(2, 1, 1000);
        $book->addPrice($price1);

        $this->tester->seeRecord('books', [
            'id'            => $book->id,
            'lowest_price'  => \App\Helpers\Price::convertDecimalToInteger($price1),
            'highest_price' => \App\Helpers\Price::convertDecimalToInteger($price1)
        ]);

        // now add a lower price, we expect to see only lowest_price is updated
        $price2 = number_format($price1 * (1 - 0.1), 2, '.', '');
        $book->addPrice($price2);

        $this->tester->seeRecord('books', [
            'id'            => $book->id,
            'lowest_price'  => \App\Helpers\Price::convertDecimalToInteger($price2),
            'highest_price' => \App\Helpers\Price::convertDecimalToInteger($price1)
        ]);

        // now add a higher price, we expect to see only highest_price is updated
        $price3 = number_format($price1 * (1 + 0.1), 2, '.', '');
        $book->addPrice($price3);

        $this->tester->seeRecord('books', [
            'id'            => $book->id,
            'lowest_price'  => \App\Helpers\Price::convertDecimalToInteger($price2),
            'highest_price' => \App\Helpers\Price::convertDecimalToInteger($price3)
        ]);
    }

    public function test_removing_price()
    {
    }
}