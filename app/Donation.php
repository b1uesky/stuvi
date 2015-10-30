<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{

    protected $table = 'donations';
    protected $guarded = [];

    /*
	|--------------------------------------------------------------------------
	| Relationships
	|--------------------------------------------------------------------------
	*/

    public function donator()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function courier()
    {
        return $this->belongsTo('App\User', 'courier_id');
    }

    public function address()
    {
        return $this->belongsTo('App\Address', 'address_id');
    }

    /*
	|--------------------------------------------------------------------------
	| Scopes
	|--------------------------------------------------------------------------
	*/

    /**
     * Get donations that are not assigned to couriers.
     *
     * @param $query
     * @return mixed
     */
    public function scopeUnassigned($query)
    {
        return $query->whereNull('courier_id');
    }

    /**
     * Get donations that are assigned to a courier.
     *
     * @param $query
     * @param int $courier_id
     * @return mixed
     */
    public function scopeAssignedTo($query, $courier_id)
    {
        return $query->where('courier_id', '=', $courier_id);
    }

    /**
     * Get donations that are not picked up.
     *
     * @param $query
     * @return mixed
     */
    public function scopeNotPickedup($query)
    {
        return $query->whereNull('pickup_time');
    }

    /**
     * Get donations that are picked up.
     *
     * @param $query
     * @return mixed
     */
    public function scopePickedup($query)
    {
        return $query->whereNotNull('pickup_time');
    }
}
