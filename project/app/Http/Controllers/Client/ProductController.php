<?php

namespace App\Http\Controllers\Client;

use App\Action\Client\CreateProductAction;
use App\Action\Client\UpdateProductAction;
use App\Builders\PaginationBuilder;
use App\Http\Controllers\Controller;
use App\Http\Requests\Client\ProductRequest;
use App\Http\Resources\Client\ProductResource;
use App\Models\Product;
use App\Repositories\CategoryRepository;
use App\Repositories\Criterias\Common\Where;
use App\Repositories\ProductRepository;

class ProductController extends Controller
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
        $this->middleware('permission:products update_stock')->only(['updateStock']);
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
        $categoryRepository = new CategoryRepository();
        $categories = $categoryRepository->toVSelect();

        return view('client.products.create', compact('categories'));
    }

    public function store(CreateProductAction $createProductAction, ProductRequest $request)
    {
        $data = $request->validated();
        $createProductAction->execute($data);
        return $this->chooseReturn('success', 'Produto criado com sucesso', 'client.products.index');
    }

    public function edit(Product $product)
    {
        $categoryRepository = new CategoryRepository();
        $categories = $categoryRepository->toVSelect();
        return view('client.products.edit', compact('product', 'categories'));
    }

    public function update(UpdateProductAction $updateProductAction, $id, ProductRequest $request)
    {
        $data = $request->validated();
        $updateProductAction->execute($id, $data);
        return $this->chooseReturn('success', 'Produto criado com sucesso', 'client.products.index');
    }

    public function duplicate(Product $product)
    {
        $productDuplicated = $product->replicate();
        $productDuplicated->save();
        return $this->chooseReturn('success', 'Produto duplicado com sucesso', 'client.products.index');
    }

    public function editStock(Product $product)
    {
        return view('client.products.edit-stock', compact('product'));
    }

    public function updateStock(UpdateProductAction $updateProductAction, $id, ProductRequest $request)
    {
        $data = $request->validated();
        $updateProductAction->execute($id, $data);
        return $this->chooseReturn('success', 'Produto criado com sucesso', 'client.products.index');
    }

    public function getProductsByCategoryId($categoryId)
    {
        $productRepository = new ProductRepository();
        $products = $productRepository->pushCriteria(new Where('category_id', $categoryId))->all();

        $products = $products->map(function ($product) {
            return ['label' => $product->title, 'id' => $product->id, 'price_nfe' => $product->formatted_price_nfe];
        });

        $products = $products->sortBy('label')->values();
        return $products;
    }

    /**
     * Configura a paginação.
     *
     * @param PaginationBuilder $pagination
     * @return void
     */
    protected function getPagination($pagination)
    {
        $productRepository = new ProductRepository();

        $pagination->repository($productRepository)
            ->defaultOrderBy('updated_at')
            ->resource(ProductResource::class);
    }
}
