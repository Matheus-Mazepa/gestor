<?php

namespace App\Repositories;

use App\Models\State;

class StatesRepository extends Repository
{
    protected function getClass()
    {
        return State::class;
    }

    public function findByAbbr($abbr)
    {
        return $this->findBy('abbr', $abbr)->first();
    }

    public function toVSelect()
    {
        $states = $this->all(['abbr', 'name']);

        $states = $states->map(function ($state) {
            return ['label' => $state->name, 'abbr' => $state->abbr];
        });

        $states = $states->sortBy('label')->values();

        return $states;
    }

    public function getStatesToSelect($key = 'label', $value = 'value')
    {
        $this->resetQuery();
        $this->applyCriteria();
        $states = $this->model
            ->orderBy('name', 'asc')
            ->get();

        $states = $states->map(function ($state) use ($key, $value) {
            return [$key => $state->formatted_name, $value => $state->abbr];
        });

        return $states;
    }

    public function toVSelectWithId($key = 'label', $value = 'value')
    {
        $states = $this->all(['id', 'name']);

        $states = $states->map(function ($state) use ($key, $value) {
            return [$key => $state->name, $value => $state->id];
        });

        $states = $states->sortBy('label')->values();

        return $states;
    }
}
