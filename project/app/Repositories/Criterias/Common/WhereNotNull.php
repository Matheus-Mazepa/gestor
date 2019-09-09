<?php

namespace App\Repositories\Criterias\Common;

use App\Base\Criteria;
use App\Base\Repository;

class WhereNotNull extends Criteria
{
    private $field;

    public function __construct($field)
    {
        $this->field = $field;
    }

    public function apply($queryBuilder, Repository $repository)
    {
        return $queryBuilder->whereNotNull($this->field);
    }
}
