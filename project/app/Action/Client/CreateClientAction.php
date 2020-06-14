<?php

namespace App\Actions\Client;

use App\Models\Client;
use App\Repositories\ClientRepository;
use App\Repositories\StatesRepository;

class CreateClientAction
{
    public function execute($data) : Client
    {
        $stateRepository = new StatesRepository();

        $addressData = data_get($data, 'address');
        $addressData['state_id'] = $stateRepository
            ->findBy('abbr', data_get($addressData, 'state'))
            ->first()->id;

        $data['is_legal_person'] = $data['is_legal_person'] === 'cnpj';
        $data['company_id'] = current_user()->company_id;

        $clientRepository = new ClientRepository();
        $client = $clientRepository->create($data);
        $client->address()->create($addressData);

        return $client;
    }
}
