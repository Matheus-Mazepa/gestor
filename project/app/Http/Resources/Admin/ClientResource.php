<?php

namespace App\Http\Resources\Admin;

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
                'edit' => $this->when(true, route('admin.users.client.edit', $this->id)),
                'show' => $this->when(true, route('admin.users.client.show', $this->id)),
                'destroy' => $this->when(true, route('admin.users.client.destroy', $this->id)),
            ],
        ];
    }
}
