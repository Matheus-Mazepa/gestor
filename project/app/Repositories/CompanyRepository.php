<?php
namespace App\Repositories;

use App\Models\Company;

class CompanyRepository extends Repository
{
    protected function getClass()
    {
        return Company::class;
    }
}
