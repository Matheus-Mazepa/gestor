<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Resources\Client\TemplateImageResource;
use App\Repositories\TemplateImageRepository;
use Illuminate\Http\Request;

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
        return view('client.template-images.index');
    }

    public function show()
    {
        return view('client.template-images.show');
    }

    public function edit($id)
    {
        $layout = $this->repository->findOrNew($id);

        return view('client.template-images.edit');
    }

    public function chooseTemplateImage(Request $request, $id)
    {
        $layout = $this->repository->findOrNew($id);

        return response()->json([
            'situation' => $request['situation']
        ], 200);
    }

    protected function getPagination($pagination)
    {
        $pagination->repository($this->repository)
            ->resource($this->resource)
            ->perPage($this->perPage);
    }
}
