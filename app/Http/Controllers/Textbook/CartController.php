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
use App\Helpers\Price;
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

        // make sure no sold items in the cart
        if (!$this->cart->isValid())
        {
            $this->cart->removeSoldItems();
            Session::flash('error', 'One or more items in your cart was sold. Please confirm your items before checking out.');
        }

        return view('cart.index')
            ->with('items', $items)
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
        $book_title = $item->book->title;

        if ($item)
        {
            if ($this->cart->hasProduct($item->id))
            {
                Session::flash('error', $book_title . ' has already been added to the cart.');
            }
            elseif ($item->sold)
            {
                Session::flash('error', $book_title . ' has been sold.');
            }
            elseif ($item->seller_id == Auth::id())
            {
                Session::flash('error', 'Can not add your own book to the cart.');
            }
            else
            {
                $this->cart->add($item);
                return redirect('/cart');
            }
        }
        else
        {
            Session::flash('error', 'Sorry, we cannot find the book you want.');
        }

        return redirect()->back();
    }

    /**
     * Add item by AJAX.
     *
     * @return mixed
     */
    public function addItemAjax()
    {
        $item = Product::find(Input::get('product_id'));

        if ($item)
        {
            if ($this->cart->hasProduct($item->id))
            {
                return Response::json([
                    'success'   => false,
                    'message'   => 'Item has already been added to the cart.'
                ]);
            }
            elseif ($item->sold)
            {
                return Response::json([
                    'success'   => false,
                    'message'   => 'Product has been sold.'
                ]);
            }
            elseif ($item->seller_id == Auth::id())
            {
                return Response::json([
                    'success'   => false,
                    'message'   => 'Can not add your own product to the cart.'
                ]);
            }
            else
            {
                $this->cart->add($item);

                return Response::json([
                    'success'   => true,
                    'quantity' => $this->cart->quantity,
                    'message'   => 'Product Added Successfully.'
                ]);
            }
        }
        else
        {
            return Response::json([
                'success'   => false,
                'message'   => 'Sorry, we cannot find the product.'
            ]);
        }
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
            ->with('info', $message);
    }

    /**
     * Remove cart item by ajax.
     *
     * @return Response
     */
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
                'removed'   => true,
                'subtotal'  => $this->cart->subtotal(),
                'quantity' => $this->cart->quantity
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
        $this->cart->removeSoldItems();

        return redirect('cart');
    }


}
