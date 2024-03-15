<?php

namespace Samuelrochac\LaravelBrasilCeps\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = ['state_id', 'name', 'slug'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        
        $prefix = config('brasil_ceps.db_prefix') ?? 'brasil_zip_codes_';

        $this->table = $prefix.'cities';
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function districts()
    {
        return $this->hasMany(District::class);
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }
}
