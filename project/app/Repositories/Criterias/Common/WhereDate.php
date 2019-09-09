<?php

namespace App\Repositories\Criterias\Common;

use App\Base\Criteria;
use App\Base\Repository;

class WhereDate extends Criteria
{
    private $date;
    private $field;
    private $operator;

    public function __construct($field, $date, $operator = '=')
    {
        $this->date = $date;
        $this->field = $field;
        $this->operator = $operator;
    }

    public function apply($queryBuilder, Repository $repository)
    {
        return $queryBuilder->whereDate($this->field, $this->operator, $this->date);
    }
}
