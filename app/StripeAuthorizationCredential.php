<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StripeAuthorizationCredential extends Model
{
    /**
     * Get the user which this Stripe authorization credential belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    /**
     * Add a Stripe authorization credential for an user.
     *
     * @param $resp
     * @param $user_id
     *
     * @return StripeAuthorizationCredential
     */
    public static function add($resp, $user_id)
    {
        $credential = new StripeAuthorizationCredential;
        $credential->user_id        = $user_id;
        $credential->access_token   = $resp['access_token'];
        $credential->refresh_token  = $resp['refresh_token'];
        $credential->token_type     = $resp['token_type'];
        $credential->scope          = $resp['scope'];
        $credential->stripe_user_id = $resp['stripe_user_id'];
        $credential->stripe_publishable_key = $resp['stripe_publishable_key'];

        $credential->save();

        return $credential;
    }
}
