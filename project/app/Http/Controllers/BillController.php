<?php

namespace App\Http\Controllers;

use App\Builders\PaginationBuilder;
use App\Repositories\BillRepository;
use Illuminate\Http\Request;

class BillController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('bills.index');
    }

    public function create()
    {
        return view('bills.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $billRepository = new BillRepository();
        $billRepository->create($data);
        return $this->chooseReturn('success', 'Conta criado com sucesso', 'bills.index');
    }

    public function pagination()
    {
        $pagination = new PaginationBuilder();

        $billRepository = new BillRepository();

        $pagination->repository($billRepository)
            ->defaultOrderBy('title');

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
