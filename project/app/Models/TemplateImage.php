<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

use App\Scopes\Search as SearchScope;

class TemplateImage extends Model
{
    use Notifiable, SearchScope;

    protected $searchBy = [
        'title'
    ];

    protected $fillable = [
        'title', 'description', 'path_content',
    ];
}
