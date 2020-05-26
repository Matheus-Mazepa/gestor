<?php

namespace App\Http\Controllers\Client;

use App\Actions\Client\CreateProductAction;
use App\Actions\Client\UpdateProductAction;
use App\Builders\PaginationBuilder;
use App\Exceptions\Repositories\RepositoryException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Client\ProductRequest;
use App\Http\Resources\Client\CategoryResource;
use App\Models\Category;
use App\Models\Product;
use App\Repositories\CategoryRepository;
use App\Repositories\OrderRepository;

class OrderController extends Controller
{
    /**
     * Show the application orders.
     *
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:orders view')->only(['index', 'show']);
        $this->middleware('permission:orders create')->only(['create', 'store']);
        $this->middleware('permission:orders update')->only(['edit', 'update']);
        $this->middleware('permission:orders delete')->only('destroy');
    }

    public function index()
    {
        return view('client.orders.index');
    }

    public function show(Category $category)
    {
        return view('client.orders.show', compact('category'));
    }

    public function create()
    {
        $categoryRepository = new CategoryRepository();
        $orders = $categoryRepository->toVSelect();

        return view('client.orders.create', compact('orders'));
    }

    public function store(CreateProductAction $createProductAction, ProductRequest $request)
    {
        $data = $request->validated();
        $createProductAction->execute($data);
        return $this->chooseReturn('success', 'Pedido cadastrado com sucesso', 'client.orders.index');
    }

    public function edit(Product $product)
    {
        return view('client.orders.edit', compact('product'));
    }

    public function update(UpdateProductAction $updateProductAction, $id, ProductRequest $request)
    {
        $data = $request->validated();
        $updateProductAction->execute($id, $data);
        return $this->chooseReturn('success', 'Pedido criado com sucesso', 'client.orders.index');
    }

    /**
     * Configura a paginação.
     *
     * @param PaginationBuilder $pagination
     * @return void
     * @throws RepositoryException
     */
    protected function getPagination($pagination)
    {
        $pagination->repository(new OrderRepository())
            ->defaultOrderBy('name')
            ->resource(CategoryResource::class);
    }
}
