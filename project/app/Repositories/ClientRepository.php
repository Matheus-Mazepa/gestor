<?php
namespace App\Repositories;

use App\Models\Client;

class ClientRepository extends Repository
{
    protected function getClass()
    {
        return Client::class;
    }
}
