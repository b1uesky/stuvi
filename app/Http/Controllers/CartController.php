<?php namespace App\Http\Controllers;
/**
 * Created by PhpStorm.
 * User: Tianyou Luo
 * Date: 5/28/15
 * Time: 3:25 PM
 */

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Cart;

class CartController extends Controller
{
    /**
     * Display a listing of products added into Cart.
     *
     * @return Response
     */
    public function index()
    {
        Cart::destroy();
        /*
        Cart::add(array(
            array('id' => '293ad', 'name' => 'Product 1', 'qty' => 1, 'price' => 10.00),
            array('id' => '4832k', 'name' => 'Product 2', 'qty' => 1, 'price' => 10.00, 'options' => array('size' => 'large'))
        ));
        */
        Cart::associate('App\Product')->add('1', 'Product 1', 1, 9.99);


        $content = Cart::content();

        return view('cart.index')->withProducts($content);
    }
}