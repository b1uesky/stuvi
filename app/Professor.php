<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Professor extends Model
{
    /**
     * Get all universities that this professor belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function universities()
    {
        return $this->belongsToMany('App\University', 'professor_university', 'professor_id', 'university_id');
    }

    /**
     * Get all courses that belongs to this professor.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function courses()
    {
        return $this->hasMany('App\Course', 'professor_id', 'id');
    }
}
