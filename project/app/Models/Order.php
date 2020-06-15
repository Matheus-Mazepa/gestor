<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'client_id',
        'payment_form_id',
        'observation',
        'company_id',
        'status',
    ];

    public function productItems()
    {
        return $this->hasMany(ProductItem::class, 'order_id', 'id');
    }

    public function address()
    {
        return $this->morphOne(Address::class, 'address_owner');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'id');
    }

    public function paymentForm()
    {
        return $this->belongsTo(PaymentForm::class, 'payment_form_id', 'id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function getTotalAttribute() {
        $total = 0;
        foreach ($this->productItems as $productItem) {
            $total += $productItem->total;
        }
        return $total;
    }
}
