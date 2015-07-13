<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use App\Product;
use App\SellerOrder;

use Illuminate\Http\Request;

class AdminController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('admin.index', [
            'user_count'            => User::count(),
            'product_count'         => Product::count(),
            'seller_order_count'    => SellerOrder::count()
        ]);
	}
}
