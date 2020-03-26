<?php

namespace App\Http\Controllers\Client;

use App\Builders\PaginationBuilder;
use App\Http\Controllers\Controller;
use App\Http\Resources\Client\ProductResource;
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
        $this->middleware('permission:products view')->only(['index', 'show']);
        $this->middleware('permission:products create')->only(['create', 'store']);
        $this->middleware('permission:products update')->only(['edit', 'update']);
        $this->middleware('permission:products delete')->only('destroy');
    }

    public function index()
    {
        return view('client.products.index');
    }

    public function create()
    {
        return view('client.products.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['price_nfc'] = remove_mask_moneyAndChangeToCent($data['price_nfc']);
        $data['price_nfe'] = remove_mask_moneyAndChangeToCent($data['price_nfe']);
        $productRepository = new ProductRepository();
        $productRepository->create($data);
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
