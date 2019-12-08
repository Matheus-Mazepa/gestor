<?php
namespace App\Repositories;

use App\Models\Product;

class ProductRepository extends Repository
{
    protected function getClass()
    {
        return Product::class;
    }

}
