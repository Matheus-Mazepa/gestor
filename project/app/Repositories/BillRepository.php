<?php
namespace App\Repositories;

use App\Models\Bill;

class BillRepository extends Repository
{
    protected function getClass()
    {
        return Bill::class;
    }

}
