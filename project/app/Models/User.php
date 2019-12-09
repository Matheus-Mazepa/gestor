<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

use App\Scopes\Search as SearchScope;

class User extends Authenticatable
{
    use Notifiable, HasRoles, SearchScope;

    protected $searchBy = [
        'name', 'email',
    ];


    protected $fillable = [
        'name', 'email', 'password', 'company_id',
    ];

    protected static $logAttributes = [
        'name', 'email'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function company()
    {
        return $this->hasOne(Company::class, 'company_id', 'id');
    }
}
