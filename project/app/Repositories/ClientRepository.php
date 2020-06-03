<?php
namespace App\Repositories;

use App\Models\Client;

class ClientRepository extends Repository
{
    protected function getClass()
    {
        return Client::class;
    }

    public function toVSelect()
    {
        $clients = $this->all(['id', 'name']);

        $clients = $clients->map(function ($client) {
            $address = $client->addresses()->first();
            $label = $client->name . ' - ' . $address->format_address;

            return ['label' => $label, 'id' => $client->id];
        });

        $clients = $clients->sortBy('label')->values();

        return $clients;
    }
}
