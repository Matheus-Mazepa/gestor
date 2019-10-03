<?php

namespace App\Http\Resources\Client;

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
                'show' => $this->when(true, route('client.template_images.show', $this->id)),
//                'edit' => $this->when(true, route('client.templates.edit', $this->id)),
                'choose_template' => $this->when(true, route(
                    'ajax.client.choose_template_image',
                    $this->id
                )),
            ],
        ];
    }
}
