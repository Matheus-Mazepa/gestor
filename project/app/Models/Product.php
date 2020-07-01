<?php

namespace App\Models;

use App\Scopes\Search as SearchScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SearchScope, SoftDeletes;

    protected $searchBy = [
        'code',
        'title',
    ];

    protected $searchByRelationship = [
        'category' => [
            'name',
        ],
    ];

    protected $fillable = [
        'code',
        'title',
        'description',
        'price_nfc',
        'price_nfe',
        'ncm',
        'price_nfc',
        'commercial_unit',
        'taxable_unit',
        'cfop_nfc',
        'cfop_nfe',
        'quantity',
        'minimal_quantity',
        'company_id',
        'category_id',
        'taxable_quantity',
        'is_bundle_product',
    ];

    protected static $logAttributes = [
        'title', 'description', 'ncm', 'code', 'price_nfe', 'commercial_unit'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_has_bundle_products', 'bundle_id', 'product_id');
    }

    public function getFormattedPriceNfeAttribute()
    {
        return number_format($this->price_nfe / 100, 2, ',', '.');
    }

    public function getFormattedPriceNfcAttribute()
    {
        return number_format($this->price_nfc / 100, 2, ',', '.');
    }
}
