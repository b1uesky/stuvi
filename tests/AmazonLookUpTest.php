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
     * Test getListPriceFormattedPrice().
     *
     */
    public function testGetListPriceFormattedPrice()
    {
        $amazon = new AmazonLookUp('098478280X', 'ISBN');
        $expected = '$39.95';
        $actual = $amazon->getListPriceFormattedPrice();

        $this->assertEquals($expected, $actual);
    }

    /**
     * Test getLargeImage().
     */
    public function testGetLargeImage()
    {
        $amazon = new AmazonLookUp('1475293534', 'ISBN');
        $expected = 'http://ecx.images-amazon.com/images/I/41pZzF%2Bu-xL.jpg';
        $actual = $amazon->getLargeImage();

        $this->assertEquals($expected, $actual);
    }

    public function testGetEdition()
    {
        $amazon = new AmazonLookUp('1848829345', 'ISBN');

        $expected = '2011';
        $actual = $amazon->getEdition();

        $this->assertEquals($expected, $actual);
    }

}
