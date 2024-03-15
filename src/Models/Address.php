<?php

namespace Samuelrochac\LaravelBrasilCeps\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = ['city_id', 'district_id', 'address', 'postal_code', 'latitude', 'longitude', 'ddd'];

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id', 'id');
    }

    public function state()
    {
        return $this->belongsTo(State::class, 'state_id', 'id');
    }

}
