<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Scopes\Search;

class Address extends Model
{
    use Search;

    protected $searchBy = [
        'street_avenue',
        'type',
        'district',
        'cep'
    ];

    protected $fillable = [
        'cep',
        'number',
        'city_id',
        'state_id',
        'district',
        'complement',
        'street_avenue',
        'address_owner_type',
        'address_owner_id'
    ];

    public function address_owner()
    {
        return $this->morphTo();
    }

    public function city()
    {
        return $this->belongsTo('App\Models\City');
    }

    public function getFormatAddressAttribute()
    {
        $city = $this->city->name;
        $state = $this->city->state->abbr;
        $district = $this->district;
        $street = $this->street_avenue;
        $number = $this->number;

        return "{$street}, {$number} - {$district} - {$city} - {$state}";
    }
}
