<?php

namespace App\Http\Controllers\Client;

use App\Builders\PaginationBuilder;
use App\Http\Controllers\Controller;
use App\Repositories\BillRepository;
use App\Repositories\PaymentFormRepository;
use App\Repositories\Repository;
use Illuminate\Http\Request;

class BillController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('client.bills.index');
    }

    public function create()
    {
        $paymentForms = (new PaymentFormRepository())->toVSelect();
        return view('client.bills.create', compact('paymentForms'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $billRepository = new BillRepository();
        $billRepository->create($data);
        return $this->chooseReturn('success', 'Conta criado com sucesso', 'client.bills.index');
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
