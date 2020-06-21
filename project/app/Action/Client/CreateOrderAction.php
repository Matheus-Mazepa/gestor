<?php

namespace App\Actions\Client;

use App\Enums\OrderStatusEnum;
use App\Models\Order;
use App\Repositories\ClientRepository;
use App\Repositories\OrderRepository;

class CreateOrderAction
{
    public function execute($data) : Order
    {
        $data['company_id'] = current_user()->company_id;
        $data['seller_id'] = current_user()->id;
        $orderRepository = new OrderRepository();

        $clientRepository = new ClientRepository();
        $client = $clientRepository->find(data_get($data, 'client_id'));
        $data['status'] = OrderStatusEnum::WAITING_DELIVERY;
        $orderAddress = $client->address->replicate();

        $order = $orderRepository->create($data);

        $orderAddress['address_owner_type'] = get_class($order);
        $orderAddress['address_owner_id'] = $order->id;
        $orderAddress->save();

        $productItems = data_get($data, 'products');
        foreach ($productItems as $productItem) {
            $valueCents = remove_mask_money($productItem['value']) * 100;
            $valueCents = intval($valueCents);
            $productItem['value_cents'] = $valueCents;

            $order->productItems() ->create($productItem);
        }
        return $order;
    }
}
