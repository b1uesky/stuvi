<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    /**
     * The database table used by the model
     *
     * @var string
     */
    protected $table = 'user_profiles';

    protected $fillable = [
        'user_id',
        'sex',
        'birthday',
        'title',
        'bio',
        'graduation_date',
        'major',
        'facebook',
        'twitter',
        'linkedin',
        'website',
        'paypal'
    ];

    /**
     * Get the user who owns this profile.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

}
