<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use App\Scopes\Search as SearchScope;

class Supplier extends Model
{
    use Notifiable, HasRoles, SearchScope;

    protected $searchBy = [
        'name', 'cnpj'
    ];


    protected $fillable = [
        'name', 'cnpj', 'email', 'phone', 'company_id'
    ];

    protected static $logAttributes = [
        'name', 'cnpj'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }
}
