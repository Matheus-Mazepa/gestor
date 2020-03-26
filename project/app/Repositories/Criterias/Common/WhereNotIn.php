<?php


namespace App\Repositories\Criterias\Common;

use App\Repositories\Criterias\Criteria;
use App\Repositories\Repository;

class WhereNotIn extends Criteria
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
        return $queryBuilder->whereNotIn($this->field, $this->values);
    }
}
