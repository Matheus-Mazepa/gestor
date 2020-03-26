<?php

namespace App\Repositories\Criterias\Common;

use App\Repositories\Criterias\Criteria;
use App\Repositories\Repository;

class WhereRaw extends Criteria
{
    private $sql;

    public function __construct($sql)
    {
        $this->sql = $sql;
    }

    public function apply($queryBuilder, Repository $repository)
    {
        return $queryBuilder->whereRaw($this->sql);
    }
}
