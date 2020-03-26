<?php

namespace App\Repositories\Criterias\Common;

use App\Repositories\Criterias\Criteria;
use App\Repositories\Repository;

class OrWhere extends Criteria
{
    /**
     * Arguments for where clause
     * @var array
     */
    private $arguments;

    /**
     * Add a orWhere clause to the query.
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
        return $queryBuilder->orWhere(...$this->arguments);
    }
}
