<?php

namespace App\Http\Controllers\Textbook;

use App\Donation;
use App\Events\DonationWasCreated;
use App\Helpers\DateTime;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class DonationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('donation.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $v = Validator::make(Input::all(), Donation::rules());

        if ($v->fails())
        {
            return redirect()->back()
                ->with('errors', $v->errors());
        }

        $donation = Donation::create([
            'user_id'               => Auth::id(),
            'address_id'            => Input::get('address_id'),
            'scheduled_pickup_time' => DateTime::saveDatetime(Input::get('scheduled_pickup_time')),
            'quantity'              => Input::get('quantity'),
            'pickup_code'           => \App\Helpers\generateRandomNumber(4)
        ]);

        event(new DonationWasCreated($donation));

        return redirect('textbook/donate/' . $donation->id . '/confirmation');
    }

    /**
     * Show the confirmation page after user donates books.
     *
     * @param Donation $donation
     * @return \Illuminate\View\View
     */
    public function confirmation($donation)
    {
        return view('donation.confirmation')
            ->with('donation', $donation);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
