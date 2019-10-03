<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\Resource;

class AdminResource extends Resource
{
    public function toArray($request)
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'created_at' => format_date($this->created_at),
            'updated_at' => format_date($this->updated_at),

            'links' => [
                'edit' => $this->when(true, route('admin.users.admin.edit', $this->id)),
                'show' => $this->when(true, route('admin.users.admin.show', $this->id)),
                'destroy' => $this->when(true, route('admin.users.admin.destroy', $this->id)),
            ],
        ];
    }
}
