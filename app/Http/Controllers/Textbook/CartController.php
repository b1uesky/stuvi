<?php namespace App\Http\Controllers\Textbook;
/**
 * Created by PhpStorm.
 * User: Tianyou Luo
 * Date: 5/28/15
 * Time: 3:25 PM
 */

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Product;
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
        $content = Cart::content();

        return view('cart.index')->withItems($content)->with('total_price', Cart::total());
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
                Session::flash('alert-class', 'alert-success');
            }
            elseif ($item->sold)
            {
                Session::flash('message', 'Product has been sold.');
                Session::flash('alert-class', 'alert-danger');
            }
            else
            {
                Cart::add($id, $item->book->title, 1, $item->price, array('item' => $item));
            }
        }
        else
        {
            Session::flash('message', 'Sorry, cannot find the product.');
            Session::flash('alert-class', 'alert-danger');
        }
        return redirect('/cart');
    }

    /**
     * Remove a item from Cart.
     *
     * @param $id  The ID of the row to fetch
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function removeItem($id)
    {
        try
        {
            Cart::remove($id);
            Session::flash('message', 'The item has been removed from Cart');
            Session::flash('alert-class', 'alert-info');
        }
        catch (\Exception $e)
        {
            Session::flash('message', 'Sorry, the item has already been removed.');
            Session::flash('alert-class', 'alert-warning');
            return redirect('/cart');
        }

        return redirect('/cart');
    }

    public function emptyCart()
    {
        Cart::destroy();

        return redirect('/cart');
    }


}
