<?php

namespace App\Http\Controllers\Admin;

use App\BuyerOrder;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Input;

class BuyerOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $filter   = Input::get('filter');
        $keyword  = strtolower(Input::get('keyword'));
        $order_by = Input::get('order_by', 'id');
        $order    = Input::get('order', 'DESC');

        // filter
        if (empty($keyword))
        {
            $query = BuyerOrder::query();
        }
        elseif ($filter == 'id')
        {
            $query = BuyerOrder::where('buyer_orders.id', intval($keyword));
        }
        elseif ($filter == 'buyer')
        {
            $query = BuyerOrder::buildQueryWithBuyerName($keyword);
        }
        else
        {
            $query = BuyerOrder::query();
        }

        // order
        if ($order_by == 'first_name' || $order_by == 'last_name')
        {
            $query = $query->join('users', 'buyer_orders.buyer_id', '=', 'users.id')
                           ->select('buyer_orders.*', 'users.'.$order_by);
        }

        $buyer_orders = $query->orderBy($order_by, $order)->paginate(config('pagination.limit.admin.buyer_order'));

        return view('admin.buyerOrder.index')
            ->with('buyer_orders', $buyer_orders)
            ->with('pagination_params', Input::only([
                                                        'filter',
                                                        'keyword',
                                                        'order_by',
                                                        'order',
                                                        'page',
                                                    ]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id`
     * @return Response
     */
    public function show($id)
    {
        return view('admin.buyerOrder.show')
            ->with('buyer_order', BuyerOrder::find($id));
    }
}
