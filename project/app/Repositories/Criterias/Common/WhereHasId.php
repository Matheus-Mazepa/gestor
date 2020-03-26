<?php

namespace App\Repositories\Criterias\Common;

use App\Repositories\Criterias\Criteria;
use App\Repositories\Repository;

class WhereHasId extends Criteria
{
    private $id;
    private $relationship;

    public function __construct($relationship, $id)
    {
        $this->id = $id;
        $this->relationship = $relationship;
    }

    public function apply($queryBuilder, Repository $repository)
    {
        $id = $this->id;

        return $queryBuilder->whereHas($this->relationship, function ($query) use ($id) {
            $query->where('suppliers.id', $id);
        });
    }
}
