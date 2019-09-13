<?php
namespace App\Repositories;

use App\Models\Layout;

class LayoutRepository extends Repository
{
    protected function getClass()
    {
        return Layout::class;
    }
}
