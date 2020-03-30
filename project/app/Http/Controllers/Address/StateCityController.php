<?php

namespace App\Http\Controllers\Address;

use App\Http\Controllers\Controller;
use App\Repositories\Criterias\Common\OrderBy;
use App\Repositories\StatesRepository;

class StateCityController extends Controller
{
    public function getStatesJson(StatesRepository $statesRepository)
    {
        $states = $statesRepository->pushCriteria(new OrderBy('name', 'asc'))->all();
        return response($states, 200);
    }

    public function getCitiesJsonFor($stateUf)
    {
        $state = (new StatesRepository())->findBy('abbr', $stateUf);
        $cities = [];

        if ($state->exists()) {
            $cities = $state->first()->cities;
        }

        return response($cities, 200);
    }
}
