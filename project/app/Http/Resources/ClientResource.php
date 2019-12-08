<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class ClientResource extends Resource
{
    public function toArray($request)
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'created_at' => format_date($this->created_at),
            'updated_at' => format_date($this->updated_at),

            'links' => [
                'edit' => $this->when(true, route('clients.edit', $this->id)),
                'show' => $this->when(true, route('clients.show', $this->id)),
                'destroy' => $this->when(true, route('clients.destroy', $this->id)),
            ],
        ];
    }
}
