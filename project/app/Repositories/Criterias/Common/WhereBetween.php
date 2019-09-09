<?php

namespace App\Repositories\Criterias\Common;

use App\Base\Criteria;
use App\Base\Repository;

class WhereBetween extends Criteria
{
    private $values;
    private $field;

    public function __construct($field, $values)
    {
        $this->values = $values;

        $this->field = $field;
    }

    public function apply($queryBuilder, Repository $repository)
    {
        return $queryBuilder->whereBetween($this->field, $this->values);
    }
}
