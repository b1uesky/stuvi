<?php

namespace App\Http\Controllers\Admin;

use App\BuyerOrder;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class BuyerOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $buyer_orders = BuyerOrder::orderBy('id', 'DESC')->paginate(config('pagination.limit.admin.buyer_order'));

        return view('admin.buyerOrder.index')
            ->with('buyer_orders', $buyer_orders);
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

    /**
     * Buyer order refund.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function refund()
    {
        $buyer_order_id = Input::get('buyer_order_id');
        $refund_amount  = intval(Input::get('refund_amount') * 100);    // convert to cent.

        $buyer_order = BuyerOrder::find($buyer_order_id);
        if ($buyer_order && $buyer_order->isRefundable() && $refund_amount <= $buyer_order->refundableAmount())
        {
            $refund = $buyer_order->refund($refund_amount, Auth::id());
            if ($refund)
            {
                return redirect('admin/order/buyer/'.$buyer_order_id)
                    ->with('message', 'Refund succeeded..');
            }
        }

        return redirect('admin/order/buyer/'.$buyer_order_id)
            ->with('message', 'Refund failed.');
    }
}
