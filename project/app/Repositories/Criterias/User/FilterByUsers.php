<?php

namespace App\Repositories\Criterias\User;

use App\Repositories\Criterias\Criteria;
use App\Repositories\Repository;

class FilterByUsers extends Criteria
{
    private $role = null;

    public function __construct($role)
    {
        $this->role = $role;
    }

    public function apply($queryBuilder, Repository $repository)
    {
        return $queryBuilder->whereHas("roles", function ($q) {
            $q->where("name", $this->role);
        });
    }
}
