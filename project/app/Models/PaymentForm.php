<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentForm extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name'
    ];
}
