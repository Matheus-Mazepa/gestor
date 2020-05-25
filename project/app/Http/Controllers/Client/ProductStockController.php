<?php

namespace App\Http\Controllers\Client;

use App\Actions\Client\CreateProductAction;
use App\Actions\Client\UpdateProductAction;
use App\Builders\PaginationBuilder;
use App\Http\Controllers\Controller;
use App\Http\Requests\Client\ProductRequest;
use App\Http\Resources\Client\ProductResource;
use App\Models\Product;
use App\Repositories\ProductRepository;

class ProductStockController extends Controller
{
    /**
     * Show the application products.
     *
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:products view')->only(['index', 'show']);
        $this->middleware('permission:products create')->only(['create', 'store']);
        $this->middleware('permission:products update')->only(['edit', 'update']);
        $this->middleware('permission:products delete')->only('destroy');
    }

    public function index()
    {
        return view('client.products.index');
    }

    public function show(Product $product)
    {
        return view('client.products.show', compact('product'));
    }

    public function create()
    {
        return view('client.products.create');
    }

    public function store(CreateProductAction $createProductAction, ProductRequest $request)
    {
        $data = $request->validated();
        $createProductAction->execute($data);
        return $this->chooseReturn('success', 'Produto criado com sucesso', 'client.products.index');
    }

    public function edit(Product $product)
    {
        return view('client.products.edit', compact('product'));
    }

    public function update(UpdateProductAction $updateProductAction, $id, ProductRequest $request)
    {
        $data = $request->validated();
        $updateProductAction->execute($id, $data);
        return $this->chooseReturn('success', 'Produto criado com sucesso', 'client.products.index');
    }

    /**
     * Configura a paginação.
     *
     * @param PaginationBuilder $pagination
     * @return void
     * @throws \App\Exceptions\Repositories\RepositoryException
     */
    protected function getPagination($pagination)
    {
        $productRepository = new ProductRepository();

        $pagination->repository($productRepository)
            ->defaultOrderBy('title')
            ->resource(ProductResource::class);
    }
}
