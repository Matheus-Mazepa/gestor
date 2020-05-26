<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'client_id',
        'payment_form_id',
    ];

    public function productItems()
    {
        return $this->hasMany(ProductItem::class, 'order_id', 'id');
    }
}
