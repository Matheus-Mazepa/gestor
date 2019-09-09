<?php

namespace App\Repositories\Criterias\Common;

use App\Base\Criteria;
use App\Base\Repository;

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
