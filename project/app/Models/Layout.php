<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

use App\Scopes\Search as SearchScope;

class Layout extends Model
{
    use Notifiable, SearchScope;

    protected $searchBy = [
        'title'
    ];

    protected $fillable = [
        'title', 'description', 'url_preview', 'path_content',
    ];
}
