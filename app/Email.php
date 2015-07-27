<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;

class Email extends Model
{
    protected $fillable = [
        'user_id',
        'email_address',
        'verification_code',
        'verified',
    ];

    /**
     * Get the user that this user email belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Check whether this email belongs to the given user
     *
     * @param $user_id
     *
     * @return bool
     */
    public function isBelongTo($user_id)
    {
        return $this->user_id == $user_id;
    }

    /**
     * Check whether this email is the primary email of the user.
     *
     * @return bool
     */
    public function isPrimary()
    {
        return $this->user->primary_email_id == $this->id;
    }

    /**
     * Check whether this email is the user's college email.
     *
     * @return bool
     */
    public function isCollegeEmail()
    {
        return $this->user->university->matchEmailSuffix($this->email_address);
    }

    /**
     * Validation register rules.
     *
     * @return array
     */
    public static function registerRules()
    {
        return [
            'email' => 'required|email|max:255|unique:emails,email_address',
        ];
    }

    /**
     * Validation login rules.
     *
     * @return array
     */
    public static function loginRules()
    {
        return [
            'email' => 'required|email|max:255',
        ];
    }

    /**
     * Assign an verification code for this email if it is not assigned.
     *
     * @return bool
     */
    public function assignVerificationCode()
    {
        if (empty($this->verification_code))
        {
            $this->verification_code = \App\Helpers\generateRandomCode(Config::get('user.verification_code_length'));
            $this->save();
            return true;
        }

        return false;
    }

    /**
     * Verify an account with a code.
     *
     * @param $code
     *
     * @return bool
     */
    public function verify($code)
    {
        if ($code === $this->verification_code)
        {
            $this->update([
                'verified'  => true,
            ]);

            return true;
        }

        return false;
    }

    /**
     * Send verification email.
     */
    public function sendVerificationEmail()
    {
        // send an email to the user with activation message
        $email_arr              = $this->toArray();
        $email_arr['user']      = $this->user->toArray();

        Mail::queue('emails.verify', ['email' => $email_arr], function($message) use ($email_arr)
        {
            $message->to($email_arr['email_address'])->subject('Please verify your email address.');
        });
    }
}
