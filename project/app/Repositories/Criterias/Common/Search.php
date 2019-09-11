<?php
namespace App\Repositories\Criterias\Common;

use Illuminate\Support\Facades\Input;

use App\Base\Criteria;
use App\Base\Repository;

class Search extends Criteria
{
    private $term;
    private $searchBy;
    private $searchByRelationship;

    public function __construct(
        string $term = null,
        array $searchBy = null,
        array $searchByRelationship = null
    ) {
        $this->term = $term;
        $this->searchBy = $searchBy;
        $this->searchByRelationship = $searchByRelationship;
    }

    public function apply($queryBuilder, Repository $repository)
    {
        if (empty($this->term)) {
            return $queryBuilder;
        }

        return $queryBuilder->search(
            $this->term,
            $this->searchBy,
            $this->searchByRelationship
        );
    }
}
