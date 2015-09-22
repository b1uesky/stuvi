<?php

namespace App\Http\Controllers\Admin;

use App\Contact;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Input;
use Mail;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $contacts = Contact::orderBy('created_at', 'DESC')->paginate(config('pagination.limit.admin.default'));
        return view('admin.contact.index')
            ->with('contacts', $contacts);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $contact = Contact::find($id);
        return view('admin.contact.show')->withContact($contact);
    }

    /**
     * Reply to the contact message by email.
     */
    public function reply()
    {
        $contact = Contact::find(Input::get('contact_id'));
        $contact_arr = $contact->toArray();
        $response = Input::get('response');

        Mail::queue('emails.contact.reply', ['contact' => $contact_arr, 'response' => $response], function ($message) use ($contact_arr)
        {
            $message->to($contact_arr['email'])->subject('A message from Stuvi');
        });

        $contact->update([
            'is_replied'    => true
        ]);

        return redirect()->back()
                    ->withSuccess('Successfully replied!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
