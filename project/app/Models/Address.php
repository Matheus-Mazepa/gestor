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
        'zip_code'
    ];

    protected $fillable = [
        'zip_code',
        'number',
        'city_id',
        'district',
        'complement',
        'street_avenue',
    ];

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
