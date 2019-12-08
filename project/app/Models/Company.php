<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use App\Scopes\Search as SearchScope;

class Company
{
    use Notifiable, HasRoles, SearchScope;

    protected $searchBy = [
        'name', 'cpf_cnpj'
    ];


    protected $fillable = [
        'name',
        'cpf_cnpj',
        'corporate_name',
        'phone',
        'ie_municipal',
        'ie_estadual',
        'is_legal_person',
        'address_id',
    ];

    protected static $logAttributes = [
        'name', 'cpf_cnpj'
    ];
}
