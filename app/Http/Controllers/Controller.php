<?php namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Product;
use Cart;
use Auth;
use Illuminate\Support\Facades\Schema;

abstract class Controller extends BaseController {

	use DispatchesCommands, ValidatesRequests;


    /**
     * check if any product in Cart belongs to the current user,
     * that is, the user is buying the product he/her is selling.
     *
     * @return bool
     */
    protected function checkCart()
    {
        foreach (Cart::content() as $row)
        {
            $product = Product::find($row->id);
            if ($product->seller_id == Auth::id())
            {
                return false;
            }
        }

        return true;
    }

    /**
     * Check if a column exists on a given table.
     *
     * @param $table
     * @param $column
     *
     * @return mixed
     */
    protected function hasColumn($table, $column)
    {
        return Schema::hasColumn($table, $column);
    }

}
