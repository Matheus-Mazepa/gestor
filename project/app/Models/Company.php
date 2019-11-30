<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use App\Scopes\Search as SearchScope;

class Company
{
    use Notifiable, HasRoles, SearchScope;

    protected $searchBy = [
        'name', 'cnpj'
    ];


    protected $fillable = [
        'name', 'cnpj'
    ];

    protected static $logAttributes = [
        'name', 'cnpj'
    ];
}
