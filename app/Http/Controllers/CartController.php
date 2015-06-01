<?php namespace App\Http\Controllers;
/**
 * Created by PhpStorm.
 * User: Tianyou Luo
 * Date: 5/28/15
 * Time: 3:25 PM
 */

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Product;
use Illuminate\Http\Request;

use Cart;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    /**
     * Display a listing of products added into Cart.
     *
     * @return Response
     */
    public function index()
    {
        /*
        Cart::destroy();

        Cart::add(array(
            array('id' => '293ad', 'name' => 'Product 1', 'qty' => 1, 'price' => 10.00),
            array('id' => '4832k', 'name' => 'Product 2', 'qty' => 1, 'price' => 10.00, 'options' => array('size' => 'large'))
        ));
        */
        //Cart::associate('App\Product')->add('1', 'Product 1', 1, 9.99);



        $content = Cart::content();

        return view('cart.index')->withItems($content);
    }

    /**
     * Add a item to Cart.
     *
     * @param $id  product id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addItem($id)
    {
        $item = Product::find($id);

        if ($item)
        {
            if ( Cart::search(array('id' => (string)$item->id)))
            {
                Session::flash('message', 'Item has been added into Cart.');
            }
            else
            {
                Cart::add($id, $item->book->title, 1, $item->price, array('item' => $item));
            }
        }
        else
        {
            Session::flash('message', 'Sorry, can not find the product.');
        }
        return redirect('/cart');
    }

    public function removeItem($product)
    {

    }

}