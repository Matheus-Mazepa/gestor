<?php

namespace App\Models;

use App\Scopes\Search as SearchScope;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use SearchScope;

    protected $searchBy = [
        'name',
    ];

    protected $fillable = [
        'name',
        'parent_id',
    ];

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function getFullNameAttribute()
    {
        return ($this->parent_id)
            ? "{$this->parent->name} > {$this->name}"
            : $this->name;
    }
}
