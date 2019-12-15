<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    protected $fillable = [
        'due_date',
        'value',
        'description',
        'company_id',
        'paid_or_scheduled',
        'payment_form_id',
    ];

    public function paymentForm() {
        return $this->hasOne(PaymentForm::class, 'payment_form_id', 'id');
    }
}
