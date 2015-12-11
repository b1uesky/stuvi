<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Major extends Model
{

    protected $table = 'majors';
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
     * Get the college that this major belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function college()
    {
        return $this->belongsTo('App\College', 'college_id', 'id');
    }

    /**
     * Get all courses that belongs to this major.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function courses()
    {
        return $this->hasMany('App\Course', 'major_id', 'id');
    }
}
