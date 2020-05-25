<?php

namespace App\Http\Resources\Client;

use Illuminate\Http\Resources\Json\Resource;

class CategoryResource extends Resource
{
    public function toArray($request)
    {
        return [
            'name' => $this->name,
            'created_at' => format_date($this->created_at),
            'updated_at' => format_date($this->updated_at),

            'links' => [
                'edit' => $this->when(true, route('client.categories.edit', $this->id)),
                'show' => $this->when(true, route('client.categories.show', $this->id)),
                'destroy' => $this->when(true, route('client.categories.destroy', $this->id)),
            ],
        ];
    }
}
