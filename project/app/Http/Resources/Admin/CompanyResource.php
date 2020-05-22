<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\Resource;

class CompanyResource extends Resource
{
    public function toArray($request)
    {
        return [
            'name' => $this->name,
            'corporate_name' => $this->corporate_name,
            'created_at' => format_date($this->created_at),
            'updated_at' => format_date($this->updated_at),

            'links' => [
//                'edit' => $this->when(true, route('admin.users.edit', $this->id)),
//                'show' => $this->when(true, route('admin.users.show', $this->id)),
//                'destroy' => $this->when(true, route('admin.users.destroy', $this->id)),
            ],
        ];
    }
}
