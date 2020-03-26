<?php

namespace App\Repositories\Criterias\Common;

use App\Repositories\Criterias\Criteria;
use App\Repositories\Repository;

class DoesntHave extends Criteria
{
    private $relation;

    public function __construct($relation)
    {
        $this->relation = $relation;
    }
    public function apply($queryBuilder, Repository $repository)
    {
        return $queryBuilder->doesntHave($this->relation);
    }
}
