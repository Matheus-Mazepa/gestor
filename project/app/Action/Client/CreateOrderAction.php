<?php

namespace App\Action\Client;

use App\Enums\OrderStatusEnum;
use App\Models\Order;
use App\Repositories\ClientRepository;
use App\Repositories\OrderRepository;
use App\Repositories\ProductRepository;

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
        $productRepository = new ProductRepository();

        foreach ($productItems as $productItem) {
            $product = $productRepository->find($productItem['product_id']);
            $valueCents = remove_mask_money($productItem['value']) * 100;
            $valueCents = intval($valueCents);
            $productItem['value_cents'] = $valueCents;

            if ($product->is_bundle_product) {
                $this->createBundleProductItems($productItem, $product, $order);
            } else {
                $order->productItems()->create($productItem);
            }
        }
        return $order;
    }

    private function createBundleProductItems($productItem, $product, $order) {
        $quantity = intval($productItem['quantity']);
        $bundleProducts = $product->products;
        $quantityPerProduct = intdiv($quantity , $bundleProducts->count());
        $bundleProducts->each(function ($product) use ($order, $productItem, &$quantity, $quantityPerProduct) {
            $productItem['product_id'] = $product->id;

            if (($quantity - $quantityPerProduct) >= $quantityPerProduct) {
                $productItem['quantity'] = $quantityPerProduct;
                $quantity -= $quantityPerProduct;
            } else {
                $productItem['quantity'] = $quantity;
            }

            $order->productItems()->create($productItem);
        });
    }
}
