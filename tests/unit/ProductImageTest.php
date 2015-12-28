<?php


class ProductImageTest extends \Codeception\TestCase\Test
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
    public function test_saving_product_image()
    {
        $product = factory(\App\Product::class)->create();
        $product_image = factory(\App\ProductImage::class)->create([
            'product_id'    => $product->id
        ]);

        $this->tester->seeRecord('product_images', $product_image->toArray());
    }
}