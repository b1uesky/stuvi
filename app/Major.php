<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Major extends Model
{
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
        return $this->hasMany('App\Course', 'college_id', 'id');
    }
}
