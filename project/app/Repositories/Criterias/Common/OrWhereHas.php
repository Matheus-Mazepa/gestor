<?php

namespace App\Repositories\Criterias\Common;

use App\Base\Criteria;
use App\Base\Repository;

class OrWhereHas extends Criteria
{
    private $closure;
    private $relationship;

    public function __construct($relationship, $closure)
    {
        $this->closure = $closure;
        $this->relationship = $relationship;
    }

    public function apply($queryBuilder, Repository $repository)
    {
        return $queryBuilder->orWhereHas($this->relationship, $this->closure);
    }
}
