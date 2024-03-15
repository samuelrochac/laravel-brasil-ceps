<?php 

namespace Samuelrochac\LaravelBrasilCeps\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ZipCodeResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'postal_code' => $this->postal_code,
            'address' => $this->address,
            'district' => $this->district->name,
            'city' => $this->city->name,
            'state' => $this->city->state->name,
            'uf' => $this->city->state->initials,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'ddd' => $this->ddd,
        ];
    }
}