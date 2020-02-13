<?php

namespace App\Http\Controllers;

use App\Builders\PaginationBuilder;
use App\Http\Resources\ProductResource;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Show the application products.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('products.index');
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $productRepository = new ProductRepository();
        $productRepository->create($data);
        return $this->chooseReturn('success', 'Produto criado com sucesso', 'products.index');
    }

    public function pagination()
    {
        $pagination = new PaginationBuilder();

        $productRepository = new ProductRepository();

        $pagination->repository($productRepository)
            ->defaultOrderBy('title')
            ->resource(ProductResource::class);

        return $pagination->build();
    }

    /**
     * Configura a paginação.
     *
     * @param PaginationBuilder $pagination
     * @return void
     */
    protected function getPagination($pagination)
    {
        // TODO: Implement getPagination() method.
    }
}
