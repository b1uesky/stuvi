<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    protected $fillable = ['user_id', 'email_address'];

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
     * @param User $user
     *
     * @return bool
     */
    public function isBelongTo(User $user)
    {
        return $this->user_id == $user->id;
    }

    /**
     * Validation register rules.
     *
     * @return array
     */
    public static function registerRules()
    {
        return [
            'email' => 'required|email|max:255|unique:user_emails,email_address',
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
}
