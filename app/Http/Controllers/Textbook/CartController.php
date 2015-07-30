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
use Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    protected $cart;

    public function __construct()
    {
        if (Auth::user())
        {
            $this->cart = Auth::user()->cart;
        }
    }

    /**
     * Display a listing of products added into Cart.
     *
     * @return Response
     */
    public function index()
    {
        $items = $this->cart->items;

        // check the Cart
        if (!$this->cart->isValid())
        {
            Session::flash('message', 'one or more items in your cart are sold. Please update your cart before proceeding to checkout.');
            Session::flash('alert-class', 'alert-danger');
        }

        return view('cart.index')
            ->with('items', $items)
            ->with('total_price', $this->cart->totalPrice());
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
            if ($this->cart->hasProduct($item->id))
            {
                Session::flash('message', 'Item has already been added to the cart.');
                Session::flash('alert-class', 'alert-danger');
            }
            elseif ($item->sold)
            {
                Session::flash('message', 'Product has been sold.');
                Session::flash('alert-class', 'alert-danger');
            }
            elseif ($item->seller_id == Auth::id())
            {
                Session::flash('message', 'Can not add your own product to the cart.');
                Session::flash('alert-class', 'alert-danger');
            }
            else
            {
                $this->cart->add($item);
            }
        }
        else
        {
            Session::flash('message', 'Sorry, cannot find the product.');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect()->back();
    }

    /**
     * @param $product_id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function removeItem($product_id)
    {
        if ($this->cart->hasProduct($product_id))
        {
            $this->cart->remove($product_id);
            $message = 'The item is removed successfully';
        }
        else
        {
            $message = 'The item is not in cart';
        }

        return redirect('/cart')
            ->with('message', $message)
            ->with('alert-class', 'alert-info');
    }

    public function emptyCart()
    {
        $this->cart->clear();

        return redirect('/cart');
    }

    public function updateCart()
    {
        $this->cart->validate();
        return redirect('cart');
    }


}
