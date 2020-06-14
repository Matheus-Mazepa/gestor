<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use App\Scopes\Search as SearchScope;

class Client extends Model
{
    use Notifiable, HasRoles, SearchScope;

    protected $searchBy = [
        'name',
    ];

    protected $fillable = [
        'name',
        'email',
        'cpf_cnpj',
        'phone',
        'ie_municipal',
        'ie_estadual',
        'is_legal_person',
        'company_id',
    ];

    protected static $logAttributes = [
        'name',
    ];

    public function address()
    {
        return $this->morphOne(Address::class, 'address_owner');
    }
}
