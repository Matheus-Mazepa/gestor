<?php

namespace App\Http\Resources\Client;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'created_at' => format_date($this->created_at),
            'updated_at' => format_date($this->updated_at),

            'links' => [
                'edit' => $this->when(true, route('client.users.edit', $this->id)),
                'show' => $this->when(true, route('client.users.show', $this->id)),
                'destroy' => $this->when(true, route('client.users.destroy', $this->id)),
            ],
        ];
    }
}
