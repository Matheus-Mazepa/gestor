<?php

namespace App\Repositories\Criterias\Common;

use App\Base\Criteria;
use App\Base\Repository;

class Has extends Criteria
{
    private $relation;

    public function __construct($relation)
    {
        $this->relation = $relation;
    }
    public function apply($queryBuilder, Repository $repository)
    {
        return $queryBuilder->has($this->relation);
    }
}
