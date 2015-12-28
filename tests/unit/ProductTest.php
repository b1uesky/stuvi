<?php


class ProductTest extends \Codeception\TestCase\Test
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
    public function test_saving_product()
    {
        $product = factory(\App\Product::class)->create();

        // price is stored as integer in db
        $expected_product = $product->toArray();
        $expected_product['price'] = \App\Helpers\Price::convertDecimalToInteger($product->price);

        $this->tester->seeRecord('products', $expected_product);
    }

    public function test_updating_product()
    {
        $product = factory(\App\Product::class)->create();
        $faker = \Faker\Factory::create();

        $product->update([
            'price'             => $faker->numberBetween(1, 1000),
            'available_at'      => $faker->date(),
            'payout_method'     => $faker->randomElement(['cash', 'paypal']),
            'accept_trade_in'   => $faker->boolean()
        ]);

        $expected_product = $product->toArray();
        $expected_product['price'] = \App\Helpers\Price::convertDecimalToInteger($product->price);

        $this->tester->seeRecord('products', $expected_product);
    }

    public function test_deleting_product()
    {
        $product = factory(\App\Product::class)->create();

        $deleted_at = \Carbon\Carbon::now();
        $product->update([
            'deleted_at' => $deleted_at,
        ]);

        $this->tester->seeRecord('products', [
            'id'            => $product->id,
            'deleted_at'    => $deleted_at
        ]);
    }
}