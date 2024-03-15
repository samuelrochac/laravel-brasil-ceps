<?php

namespace Samuelrochac\LaravelBrasilCeps\Models;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $fillable = ['name', 'initials'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        
        $prefix = config('brasil_ceps.db_prefix') ?? 'brasil_zip_codes_';

        $this->table = $prefix.'states';
    }

    public function cities()
    {
        return $this->hasMany(City::class);
    }
}
