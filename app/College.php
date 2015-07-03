<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class College extends Model
{
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
