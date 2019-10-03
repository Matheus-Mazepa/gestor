<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\TemplateImageResource;
use App\Repositories\TemplateImageRepository;

class TemplateImageController extends Controller
{
    private $repository;
    private $resource;

    private $perPage = 5;

    public function __construct()
    {
        $this->repository = new TemplateImageRepository();
        $this->resource = TemplateImageResource::class;
    }

    public function index()
    {
        return view('admin.template-images.index');
    }

    public function create()
    {
        return view('admin.template-images.create');
    }

    public function edit($id)
    {
        $templateImages = $this->repository->findOrNew($id);

        return view('admin.template-images.edit', compact('templateImages'));
    }

    public function show($id)
    {
        $templateImages = $this->repository->findOrNew($id);

        return view('admin.template-images.show', compact('templateImages'));
    }

    protected function getPagination($pagination)
    {
        $pagination->repository($this->repository)
            ->resource($this->resource)
            ->perPage($this->perPage);
    }
}
