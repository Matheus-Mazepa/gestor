<?php

namespace App\Repositories\Criterias\Common;

use Closure;
use App\Repositories\Criterias\Criteria;
use App\Repositories\Repository;

class Join extends Criteria
{
    /**
     * Arguments for join clause
     * @var array
     */
    private $arguments;


    public function __construct()
    {
        $this->arguments = func_get_args();
    }

    public function apply($queryBuilder, Repository $repository)
    {
        return $queryBuilder->join(...$this->arguments);
    }
}
