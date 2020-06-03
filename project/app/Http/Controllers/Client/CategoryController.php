<?php

namespace App\Http\Controllers\Client;

use App\Actions\Client\CreateProductAction;
use App\Actions\Client\UpdateProductAction;
use App\Builders\PaginationBuilder;
use App\Http\Controllers\Controller;
use App\Http\Requests\Client\ProductRequest;
use App\Http\Resources\Client\CategoryResource;
use App\Models\Category;
use App\Models\Product;
use App\Repositories\CategoryRepository;
use App\Repositories\Criterias\Common\Where;

class CategoryController extends Controller
{
    /**
     * Show the application categories.
     *
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:categories view')->only(['index', 'show']);
        $this->middleware('permission:categories create')->only(['create', 'store']);
        $this->middleware('permission:categories update')->only(['edit', 'update']);
        $this->middleware('permission:categories delete')->only('destroy');
    }

    public function index()
    {
        return view('client.categories.index');
    }

    public function show(Category $category)
    {
        return view('client.categories.show', compact('category'));
    }

    public function create()
    {
        $categoryRepository = new CategoryRepository();
        $categories = $categoryRepository->toVSelect(new Where('parent_id', null));

        return view('client.categories.create', compact('categories'));
    }

    public function store(CreateProductAction $createProductAction, ProductRequest $request)
    {
        $data = $request->validated();
        $createProductAction->execute($data);
        return $this->chooseReturn('success', 'Produto criado com sucesso', 'client.categories.index');
    }

    public function edit(Product $product)
    {
        return view('client.categories.edit', compact('product'));
    }

    public function update(UpdateProductAction $updateProductAction, $id, ProductRequest $request)
    {
        $data = $request->validated();
        $updateProductAction->execute($id, $data);
        return $this->chooseReturn('success', 'Produto criado com sucesso', 'client.categories.index');
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
        $pagination->repository(new CategoryRepository())
            ->defaultOrderBy('name')
            ->resource(CategoryResource::class);
    }
}
