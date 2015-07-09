<?php
/**
 * Created by PhpStorm.
 * User: Desmond
 * Date: 7/9/15
 * Time: 12:01 PM
 */

use App\Helpers\AmazonLookUp;

class AmazonLookUpTest extends TestCase {

    /**
     * Test getListPriceFormattedPrice.
     *
     * @return void
     */
    public function testGetListPriceFormattedPrice()
    {
        $amazon = new AmazonLookUp('098478280X', 'ISBN');
        $expected = '$39.95';
        $actual = $amazon->getListPriceFormattedPrice();

        $this->assertEquals($expected, $actual);
    }

}
