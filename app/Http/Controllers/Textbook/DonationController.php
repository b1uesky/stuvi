<?php

namespace App\Http\Controllers\Textbook;

use App\Donation;
use App\Events\DonationWasCreated;
use App\Helpers\DateTime;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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
     * @param Requests\StoreDonationRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\StoreDonationRequest $request)
    {
        $donation = Donation::create([
            'user_id'               => Auth::id(),
            'address_id'            => $request->get('address_id'),
            'scheduled_pickup_time' => DateTime::saveDatetime($request->get('scheduled_pickup_time')),
            'quantity'              => $request->get('quantity'),
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
}
