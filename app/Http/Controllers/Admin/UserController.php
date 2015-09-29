<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\User;
use Illuminate\Support\Facades\Validator;
use Input;


class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $filters = ['id', 'name', 'phone', 'role'];
        $filter   = Input::get('filter', 'id');
        $keyword  = strtolower(Input::get('keyword'));
        $order_by = Input::get('order_by', 'id');
        $order    = Input::get('order', 'DESC');

        if (empty($keyword))
        {
            $query = User::query();
        }
        elseif ($filter == 'id')
        {
            $query = User::where($filter, intval($keyword));
        }
        elseif ($filter == 'name')
        {
            $query = User::where('last_name', 'LIKE', '%'.$keyword.'%')
                            ->orWhere('first_name', 'LIKE', '%'.$keyword.'%');
        }
        elseif ($filter == 'phone')
        {
            $query = User::where('phone_number', '=', $keyword);
        }
        elseif ($filter == 'role')
        {
            $query = User::where($filter, 'LIKE', '%'.$keyword.'%');
        }
        else
        {
            $query = User::query();
        }

        $users = $query->orderBy($order_by, $order)->paginate(config('pagination.limit.admin.user'));

        return view('admin.user.index')
            ->with('users', $users)
            ->with('filters', $filters)
            ->with('pagination_params', Input::only([
                                                        'filter',
                                                        'keyword',
                                                        'order_by',
                                                        'order',
                                                        'page',
                                                    ]));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  User $user
     *
     * @return Response
     */
    public function show($user)
    {
        $products       = $user->productsForSale();
        $buyer_orders   = $user->buyerOrders()->orderBy('created_at', 'DESC')->get();
        $seller_orders  = $user->sellerOrders()->orderBy('created_at', 'DESC')->get();

        return view('admin.user.show')
            ->with('user', $user)
            ->with('emails', $user->emails)
            ->with('products', $products)
            ->with('buyer_orders', $buyer_orders)
            ->with('seller_orders', $seller_orders);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  User $user
     *
     * @return Response
     */
    public function edit($user)
    {
        return view('admin.user.edit')
            ->with('user', $user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  User $user
     *
     * @return Response
     */
    public function update($user)
    {
        $v = Validator::make(Input::all(), $user->updateRules());

        if ($v->fails())
        {
            return redirect()->back()->with('errors', $v->errors());
        }

        $user->update(Input::except('activated'));

        $user->primaryEmail()->update([
            'activated' => Input::get('activated')
        ]);

        return redirect('admin/user')->with('success', 'Updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User $user
     *
     * @return Response
     */
    public function destroy($user)
    {
        //
    }

}
