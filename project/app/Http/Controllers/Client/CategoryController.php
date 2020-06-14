<?php

namespace App\Http\Controllers\Client;

use App\Actions\Client\CreateProductAction;
use App\Actions\Client\UpdateProductAction;
use App\Builders\PaginationBuilder;
use App\Http\Controllers\Controller;
use App\Http\Requests\Client\CategoryRequest;
use App\Http\Requests\Client\ProductRequest;
use App\Http\Resources\Client\CategoryResource;
use App\Models\Category;
use App\Models\Product;
use App\Repositories\CategoryRepository;
use App\Repositories\Criterias\Common\Where;

class CategoryController extends Controller
{
    private $categoryRepository;

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
        $this->categoryRepository = new CategoryRepository();

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
        $categories = $this->categoryRepository->toVSelect(new Where('parent_id', null));

        return view('client.categories.create', compact('categories'));
    }

    public function store(CategoryRequest $request)
    {
        $data = $request->validated();
        $this->categoryRepository->create($data);
        return $this->chooseReturn('success', 'Categoria criado com sucesso', 'client.categories.index');
    }

    public function edit(Category $category)
    {
        $categories = $this->categoryRepository->toVSelect(new Where('parent_id', null));
        return view('client.categories.edit', compact('category', 'categories'));
    }

    public function update($id, CategoryRequest $request)
    {
        $data = $request->validated();
        $this->categoryRepository->update($id, $data);
        return $this->chooseReturn('success', 'Categoria atualizada com sucesso', 'client.categories.index');
    }

    public function destroy($id) {
        $this->categoryRepository->delete($id);

        return $this->chooseReturn('success', 'Categoria removida com sucesso');
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
