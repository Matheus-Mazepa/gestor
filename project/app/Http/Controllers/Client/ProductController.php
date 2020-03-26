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
        $data['price_nfc'] = remove_mask_moneyAndChangeToCent($data['price_nfc']);
        $data['price_nfe'] = remove_mask_moneyAndChangeToCent($data['price_nfe']);
        $productRepository = new ProductRepository();
        $productRepository->create($data);
        return $this->chooseReturn('success', 'Produto criado com sucesso', 'products.index');
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
