<?php

namespace App\Http\Resources\Client;

use Illuminate\Http\Resources\Json\Resource;

class LayoutResource extends Resource
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
            'description' => $this->description,
            'url_preview' => $this->url_preview,
            'path_content' => $this->path_content,
            'created_at' => format_date($this->created_at),

            'links' => [
                'show' => $this->when(true, route('client.layouts.show', $this->id)),
            ],
        ];
    }
}
