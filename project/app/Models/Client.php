<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use App\Scopes\Search as SearchScope;

class Client
{
    use Notifiable, HasRoles, SearchScope;

    protected $searchBy = [
        'name',
    ];


    protected $fillable = [
        'name',
        'cpf_cnpj',
        'phone',
        'ie_municipal',
        'ie_estadual',
        'is_legal_person',
        'company_id',
        'address_id',
    ];

    protected static $logAttributes = [
        'name',
    ];
}
