<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\Resource;

class User extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'created_at' => format_date($this->created_at),
            'updated_at' => format_date($this->updated_at),

            'links' => [
                'edit' => $this->when(true, route('admin.users.edit', $this->id)),
                'show' => $this->when(true, route('admin.users.show', $this->id)),
                'destroy' => $this->when(true, route('admin.users.destroy', $this->id)),
            ],
        ];
    }
}
