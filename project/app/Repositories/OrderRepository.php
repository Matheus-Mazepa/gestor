<?php
namespace App\Repositories;

use App\Models\Order;

class OrderRepository extends Repository
{
    protected function getClass()
    {
        return Order::class;
    }
}
