<?php

namespace App\Repositories\Criterias\Common;

use App\Base\Criteria;
use App\Base\Repository;

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
