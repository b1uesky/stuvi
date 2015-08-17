<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\User;
use Config;


class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $users = User::paginate(Config::get('pagination.limit.admin.user'));

        return view('admin.user.index')
            ->with('users', $users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        //
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
        //
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
        //
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
