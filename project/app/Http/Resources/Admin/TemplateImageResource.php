<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\Resource;

class TemplateImageResource extends Resource
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
            'title' => $this->title,
            'url_preview' => '',
            'path_content' => $this->path_content,
            'created_at' => format_date($this->created_at),
            'updated_at' => format_date($this->updated_at),

            'links' => [
                'show' => $this->when(true, route('admin.template_images.show', $this->id)),
                'edit' => $this->when(true, route('admin.template_images.edit', $this->id)),
                'destroy' => $this->when(true, route(
                    'admin.template_images.destroy',
                    $this->id
                )),
            ],
        ];
    }
}
