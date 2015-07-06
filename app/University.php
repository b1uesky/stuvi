<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class University extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'abbreviation', 'email_suffix'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Check if the given email has the same email suffix as this university.
     *
     * @param $email
     *
     * @return bool
     */
	public function matchEmailSuffix($email)
    {
        if (preg_match('/.*@'.$this->email_suffix.'\z/i', $email))
        {
            return true;
        }
        return false;
    }

    /**
     * Get all colleges that belongs to this university.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function colleges()
    {
        return $this->hasMany('App\College', 'university_id', 'id');
    }

    /**
     * Get all professors in this university.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function professors()
    {
        return $this->belongsToMany('App\Professor');
    }

}
