<?php

namespace App\Http\Resources\Client;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'code' => $this->code,
            'title' => $this->title,
            'description' => $this->description,
            'category_name' => $this->category->name,
            'created_at' => format_date($this->created_at),
            'updated_at' => format_date($this->updated_at),

            'links' => [
                'duplicate' => $this->when(true, route('client.product.duplicate', $this->id)),
                'edit' => $this->when(true, route('client.products.edit', $this->id)),
                'show' => $this->when(true, route('client.products.show', $this->id)),
                'destroy' => $this->when(true, route('client.products.destroy', $this->id)),
            ],
        ];
    }
}
