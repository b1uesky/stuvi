<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    /**
     * Get the major that this class belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function major()
    {
        return $this->belongsTo('App\Major', 'major_id', 'id');
    }

    /**
     * Get the professor that teaches this course.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function professor()
    {
        return $this->belongsTo('App\Professor', 'professor_id', 'id');
    }
}
