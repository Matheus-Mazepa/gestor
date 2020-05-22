<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use App\Scopes\Search as SearchScope;

class Company extends Model
{
    use Notifiable, HasRoles, SearchScope, SoftDeletes;

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
    ];

    protected static $logAttributes = [
        'name', 'cpf_cnpj'
    ];

    public function addresses()
    {
        return $this->morphMany(Address::class, 'address_owner');
    }
}
