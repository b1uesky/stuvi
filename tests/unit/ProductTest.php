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
        $product_condition = factory(\App\ProductCondition::class)->create([
            'product_id'    => $product->id
        ]);
        $product_image = factory(\App\ProductImage::class)->create([
            'product_id'    => $product->id
        ]);

        // price is stored as integer in db
        $expected_product = $product->toArray();
        $expected_product['price'] = \App\Helpers\Price::convertDecimalToInteger($product->price);

        $this->tester->seeRecord('products', $expected_product);
        $this->tester->seeRecord('product_conditions', $product_condition->toArray());
        $this->tester->seeRecord('product_images', $product_image->toArray());
    }
}