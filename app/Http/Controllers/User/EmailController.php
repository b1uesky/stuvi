<?php namespace App\Http\Controllers\User;

use App\Email;
use App\Events\UserEmailWasAdded;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class EmailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('user.email')
        ->with('emails', Auth::user()->emails);
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
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make(Input::all(), Email::registerRules());
        if ($validator->fails())
        {
            return back()
                ->with('errors', $validator->errors());
        }

        $email = Email::create([
            'user_id'       => Auth::id(),
            'email_address' => Input::get('email'),
            'verification_code' => \App\Helpers\generateRandomCode(config('mail.verification_code_length'))
        ]);

        event(new UserEmailWasAdded($email));

        return redirect('user/email')
            ->with('success', $email->email_address.' has been added to your account. Please check your email and confirm your new email address.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return Response
     */
    public function destroy()
    {
        $email = Email::find(Input::get('id'));

        if ($email && $email->isBelongTo(Auth::id()))
        {
            if ($email->isPrimary())    // cannot delete primary email
            {
                return redirect('user/email')
                    ->with('danger', 'Sorry, we cannot delete your primary email.');
            }
            elseif ($email->isCollegeEmail())   // cannot delete college email
            {
                return redirect('user/email')
                    ->with('danger', 'Sorry, we cannot delete your college email.');
            }
            else
            {
                $email->delete();
                return redirect('user/email')
                    ->with('success', $email->email_address.' has been removed.');
            }
        }

        return redirect('user/email')
            ->with('danger', 'Sorry, we did not find the email.');
    }

    /**
     * Set the primary email.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function setPrimary()
    {
        $email = Auth::user()->setPrimaryEmail(Input::get('id'));

        if (!$email)
        {
            return redirect('user/email')
                ->with('danger', 'Sorry, we did not find the email.');
        }

        return redirect('user/email')
            ->with('success', $email->email_address.' is now your primary email.');
    }

    public function verify($id, $code)
    {
        $email = Email::find($id);

        if (!($email && $email->isBelongTo(Auth::id())))
        {
            $msg_type   = 'danger';
            $msg_content = 'Sorry, the requested email cannot be found.';
        }
        elseif ($email->verify($code))
        {
            $msg_type   = 'success';
            $msg_content = $email->email_address.' has been verified successfully.';
        }
        else
        {
            $msg_type   = 'danger';
            $msg_content = 'Sorry, we cannot verify your email '.$email->email_address;
        }

        return redirect('/user/email')
            ->with($msg_type, $msg_content);
    }

}
