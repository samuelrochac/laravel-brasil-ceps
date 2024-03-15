<?php

namespace Samuelrochac\LaravelBrasilCeps\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $fillable = ['city_id', 'name', 'slug'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        
        $prefix = config('brasil_ceps.db_prefix') ?? 'brasil_zip_codes_';

        $this->table = $prefix.'districts';
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }
}
