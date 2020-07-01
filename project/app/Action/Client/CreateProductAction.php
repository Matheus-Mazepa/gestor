<?php

namespace App\Actions\Client;

use App\Models\Product;
use App\Repositories\ProductRepository;

class CreateProductAction
{
    public function execute($data) : Product
    {
        $productRepository = new ProductRepository();

        $data['company_id'] = current_user()->company_id;
        $data['price_nfc'] = remove_mask_moneyAndChangeToCent($data['price_nfc']);
        $data['price_nfe'] = remove_mask_moneyAndChangeToCent($data['price_nfe']);

        $product = $productRepository->create($data);
        $bundleProducts = data_get($data, 'products', []);
        $product->products()->sync($bundleProducts);

        return $product;
    }
}
