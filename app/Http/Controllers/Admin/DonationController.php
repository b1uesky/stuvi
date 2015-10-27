<?php

namespace App\Http\Controllers\Admin;

use App\Donation;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class DonationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $filters = ['id'];
        $filter   = Input::get('filter');
        $keyword  = strtolower(Input::get('keyword'));
        $order_by = Input::get('order_by', 'id');
        $order    = Input::get('order', 'DESC');

        // filter
        if (empty($keyword))
        {
            $query = Donation::query();
        }
        elseif ($filter == 'id')
        {
            $query = Donation::where('donations.id', intval($keyword));
        }
        else
        {
            $query = Donation::query();
        }

        $donations = $query->orderBy($order_by, $order)->paginate(config('pagination.limit.admin.default'));

        return view('admin.donation.index')
            ->with('donations', $donations)
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('admin.donation.show')
            ->with('donation', Donation::find($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
