<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class College extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'abbreviation', 'university_id'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the university that this college belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function university()
    {
        return $this->belongsTo('App\University', 'university_id', 'id');
    }

    /**
     * Get all majors that belongs to this college.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function majors()
    {
        return $this->hasMany('App\Major', 'college_id', 'id');
    }
}
