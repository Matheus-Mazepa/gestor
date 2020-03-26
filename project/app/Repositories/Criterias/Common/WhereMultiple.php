<?php

namespace App\Repositories\Criterias\Common;

use App\Repositories\Criterias\Criteria;
use App\Repositories\Repository;

class WhereMultiple extends Criteria
{
    private $fields;

    public function __construct($fields)
    {
        $this->fields = $fields;
    }

    public function apply($queryBuilder, Repository $repository)
    {
        return $queryBuilder->where($this->fields);
    }
}
