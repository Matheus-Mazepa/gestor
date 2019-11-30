<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use App\Scopes\Search as SearchScope;

class Product
{
    use Notifiable, HasRoles, SearchScope;

    protected $searchBy = [
        'title', 'description', 'ncm', 'code', 'price_nfe', 'commercial_unit'
    ];


    protected $fillable = [
        'title', 'description', 'ncm', 'code', 'price_nfe', 'commercial_unit'
    ];

    protected static $logAttributes = [
        'title', 'description', 'ncm', 'code', 'price_nfe', 'commercial_unit'
    ];
}
