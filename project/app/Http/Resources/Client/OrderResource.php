<?php

namespace App\Http\Resources\Client;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'client_name' => $this->client->name,
            'payment_form' => $this->paymentForm->name,
            'status' => __('order-status-enum.' . $this->status),

            'created_at' => format_date($this->created_at),
            'updated_at' => format_date($this->updated_at),

            'links' => [
                'print' => route('client.order.print', $this->id),
                'set_delivered' => route('ajax.client.order.set_delivered', $this->id),
//                'edit' => $this->when(true, route('client.clients.edit', $this->id)),
//                'show' => $this->when(true, route('client.clients.show', $this->id)),
//                'destroy' => $this->when(true, route('client.clients.destroy', $this->id)),
            ],
        ];
    }
}
