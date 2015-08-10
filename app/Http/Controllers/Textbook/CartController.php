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
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Response;

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
            Session::flash('message', 'One or more items in your cart has sold. Please update your cart before proceeding to checkout.');
            Session::flash('alert-class', 'alert-danger');
        }

        return view('cart.index')
            ->with('items', $items)
            ->with('tax', $this->cart->tax())
            ->with('fee', $this->cart->fee())
            ->with('discount', $this->cart->discount())
            ->with('subtotal', $this->cart->subtotal());
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
                Session::flash('message', 'Product Added Successfully.');
                Session::flash('alert-class', 'alert-success');

            }
        }
        else
        {
            Session::flash('message', 'Sorry, we cannot find the product.');
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
        $item = $this->cart->remove($product_id);
        if ($item)
        {
            $message = $item->product->book->tilte . ' has been removed successfully';
        }
        else
        {
            $message = 'The item is not in the cart';
        }

        return redirect('/cart')
            ->with('message', $message)
            ->with('alert-class', 'alert-info');
    }


    public function removeItemAjax()
    {
        $product_id = Input::get('product_id');

        $item = $this->cart->remove($product_id);

        if (!$item)  // remove failed
        {
            return Response::json([
                                      'removed' => false,
                                      'message' => 'The item is not in the cart',
                                  ]);
        }
        else
        {
            return Response::json([
                                      'removed'  => true,
                                      'message'  => $item->product->book->title . ' has been removed successfully',
                                      'fee'      => $this->cart->fee(),
                                      'discount' => $this->cart->discount(),
                                      'tax'      => $this->cart->tax(),
                                      'total'    => $this->cart->subtotal(),
                                  ]);
        }
    }

    /**
     * Empty the cart.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function emptyCart()
    {
        $this->cart->clear();

        return redirect('/cart');
    }

    /**
     * Remove the sold cart items.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function updateCart()
    {
        $this->cart->validate();

        return redirect('cart');
    }


}
