<?php
namespace App\Repositories;

use App\Models\TemplateImage;

class TemplateImageRepository extends Repository
{
    protected function getClass()
    {
        return TemplateImage::class;
    }
}
