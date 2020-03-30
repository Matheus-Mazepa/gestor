<?php

namespace App\Repositories;

use App\Models\City;

class CityRepository extends Repository
{
    protected function getClass()
    {
        return City::class;
    }
}
