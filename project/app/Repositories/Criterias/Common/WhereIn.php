<?php

namespace App\Repositories\Criterias\Common;

use App\Repositories\Criterias\Criteria;
use App\Repositories\Repository;

class WhereIn extends Criteria
{
    private $field;
    private $values;

    public function __construct($field, $values)
    {
        $this->field = $field;
        $this->values = $values;
    }

    public function apply($queryBuilder, Repository $repository)
    {
        return $queryBuilder->whereIn($this->field, $this->values);
    }
}
