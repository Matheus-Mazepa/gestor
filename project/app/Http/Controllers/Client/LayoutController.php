<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Resources\Client\LayoutResource as LayoutResource;
use App\Repositories\LayoutRepository;

class LayoutController extends Controller
{
    private $repository;
    private $resource;

    private $perPage = 5;

    public function __construct()
    {
        $this->repository = new LayoutRepository();
        $this->resource = LayoutResource::class;
    }

    public function index()
    {
        return view('client.sites.layouts.index');
    }

    public function show()
    {
        return view('client.sites.layouts.show');
    }

    protected function getPagination($pagination)
    {
        $pagination->repository($this->repository)
            ->resource($this->resource)
            ->perPage($this->perPage);
    }
}
