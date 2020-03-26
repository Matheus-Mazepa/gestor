<?php

namespace App\Repositories\Criterias\Common;

use Closure;
use App\Repositories\Criterias\Criteria;
use App\Repositories\Repository;

class Where extends Criteria
{
    /**
     * Arguments for where clause
     * @var array
     */
    private $arguments;

    /**
     * Add a basic where clause to the query.
     *
     * @param  string|array|\Closure  $column
     * @param  mixed   $operator
     * @param  mixed   $value
     * @param  string  $boolean
     * @return $this
     */
    public function __construct()
    {
        $this->arguments = func_get_args();
    }

    public function apply($queryBuilder, Repository $repository)
    {
        return $queryBuilder->where(...$this->arguments);
    }
}
