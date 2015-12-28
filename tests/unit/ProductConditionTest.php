<?php


class ProductConditionTest extends \Codeception\TestCase\Test
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
    public function test_saving_product_condition()
    {
        $product = factory(\App\Product::class)->create();
        $product_condition = factory(\App\ProductCondition::class)->create([
            'product_id'    => $product->id
        ]);

        $this->tester->seeRecord('product_conditions', $product_condition->toArray());
    }
}