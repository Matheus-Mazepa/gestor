<?php

namespace App\Actions\Client;

use App\Models\Product;
use App\Repositories\ProductRepository;

class UpdateProductAction
{
    public function execute($id, $data) : Product
    {
        $productRepository = new ProductRepository();

        $data['company_id'] = current_user()->company_id;
        $data['price_nfc'] = remove_mask_moneyAndChangeToCent($data['price_nfc']);
        $data['price_nfe'] = remove_mask_moneyAndChangeToCent($data['price_nfe']);

        $productRepository = $productRepository->update($id, $data);
        return $productRepository;
    }
}
