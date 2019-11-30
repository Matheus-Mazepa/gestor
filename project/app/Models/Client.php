<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use App\Scopes\Search as SearchScope;

class Client
{
    use Notifiable, HasRoles, SearchScope;

    protected $searchBy = [
        'name', 'cnpj/cpf', 'incricao_municipal', 'incricao_estadual'
    ];


    protected $fillable = [
        'name', 'cnpj/cpf', 'incricao_municipal', 'incricao_estadual'
    ];

    protected static $logAttributes = [
        'name', 'cnpj/cpf', 'incricao_municipal', 'incricao_estadual'
    ];
}
