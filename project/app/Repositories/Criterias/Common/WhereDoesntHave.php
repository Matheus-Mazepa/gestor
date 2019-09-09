<?php

namespace App\Repositories\Criterias\Common;

use App\Base\Criteria;
use App\Base\Repository;

class WhereDoesntHave extends Criteria
{
    private $args = [];

    public function __construct()
    {
        $this->args = func_get_args();
    }

    public function apply($queryBuilder, Repository $repository)
    {
        return $queryBuilder->whereDoesntHave(...$this->args);
    }
}
