<?php

namespace App\Http\Resources\Client;

use Illuminate\Http\Resources\Json\Resource;

class ProductResource extends Resource
{
    public function toArray($request)
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
            'created_at' => format_date($this->created_at),
            'updated_at' => format_date($this->updated_at),

            'links' => [
                'edit' => $this->when(true, route('client.products.edit', $this->id)),
                'show' => $this->when(true, route('client.products.show', $this->id)),
                'destroy' => $this->when(true, route('client.products.destroy', $this->id)),
            ],
        ];
    }
}
