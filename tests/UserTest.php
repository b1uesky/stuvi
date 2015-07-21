<?php
/**
 * Created by PhpStorm.
 * User: Desmond
 * Date: 7/21/15
 * Time: 11:32 AM
 */

use App\User;

class UserTest extends TestCase {

    public function testDefaultAddress()
    {
        $expected = 4;
        $actual = User::find(2)->defaultAddress()->id;

        $this->assertEquals($expected, $actual);
    }
}