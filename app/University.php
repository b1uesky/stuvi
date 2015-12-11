<?php namespace App;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use DB;

class University extends Model
{
    protected $table = 'universities';
    protected $guarded = [];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /*
	|--------------------------------------------------------------------------
	| Relationships
	|--------------------------------------------------------------------------
	*/

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

    /**
     * A textbook can be delivered from `other universities` to this university.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function fromUniversities()
    {
        return $this->belongsToMany('App\University', 'university_university', 'from_uid', 'id');
    }

    /**
     * A textbook can be delivered from this university to `other universities`.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function toUniversities()
    {
        return $this->hasMany('App\University', 'university_university', 'to_uid', 'id');
    }

    /*
	|--------------------------------------------------------------------------
	| Methods
	|--------------------------------------------------------------------------
	*/

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
     * Add an university so that a textbook can be delivered from this university to that university.
     *
     * @param $to_uid
     */
    public function addDeliverToUniversity($to_uid)
    {
        DB::insert('
            INSERT INTO university_university (from_uid, to_uid)
            VALUES (?, ?)',
            [$this->id, $to_uid]
        );
    }

    /**
     * Add an university so that a textbook can be delivered from that university to this university.
     *
     * @param $from_uid
     */
    public function addDeliverFromUniversity($from_uid)
    {
        DB::insert('
            INSERT INTO university_university (from_uid, to_uid)
            VALUES (?, ?)',
            [$from_uid, $this->id]
        );
    }

    /**
     * Get all universities available for registration.
     *
     * @return Collection
     */
    public static function availableUniversities()
    {
        return University::where('is_public', true)->get();
    }

}
