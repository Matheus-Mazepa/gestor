<?php

namespace App\Repositories\Criterias\Common;

use App\Base\Criteria;
use App\Base\Repository;

class WhereColumn extends Criteria
{
    private $values;
    private $operator;
    private $field;

    public function __construct($field, $operator, $values = null)
    {
        $this->values = $values;

        $this->operator = $operator;

        $this->field = $field;
    }

    public function apply($queryBuilder, Repository $repository)
    {

        return ($this->values) ?
            $queryBuilder->whereColumn($this->field, $this->operator, $this->values) :
            $queryBuilder->whereColumn($this->field, $this->operator);
    }
}
