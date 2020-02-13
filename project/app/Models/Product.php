<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use App\Scopes\Search as SearchScope;

class Product extends Model
{
    use Notifiable, HasRoles, SearchScope, SoftDeletes;

    protected $searchBy = [
        'code',
        'title',
        ];


    protected $fillable = [
        'code',
        'title',
        'price_nfe',
        'ncm',
        'price_nfc',
        'commercial_unit',
        'taxable_unit',
        'cfop_nfc',
        'cfop_nfe',
        'supplier_id',
        'quantity',
        'minimal_quantity',
        'company_id',
        'taxable_quantity',
    ];

    protected static $logAttributes = [
        'title', 'description', 'ncm', 'code', 'price_nfe', 'commercial_unit'
    ];

    public function company()
    {
        return $this->hasOne(Company::class, 'company_id', 'id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }
}
