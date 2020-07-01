<?php

namespace App\Http\Controllers\Client;

use App\Models\Order;
use App\Enums\OrderStatusEnum;
use App\Builders\PaginationBuilder;
use App\Http\Controllers\Controller;
use App\Repositories\OrderRepository;
use App\Repositories\ClientRepository;
use App\Repositories\CategoryRepository;
use App\Action\Client\CreateOrderAction;
use App\Repositories\PaymentFormRepository;
use App\Http\Requests\Client\OrderRequest;
use App\Http\Resources\Client\OrderResource;
use App\Exceptions\Repositories\RepositoryException;

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

    public function show(Order $order)
    {
        return view('client.orders.show', compact('order'));
    }

    public function create()
    {
        $clientRepository = new ClientRepository();
        $paymentFormRepository = new PaymentFormRepository();
        $clients = $clientRepository->toVSelect();
        $paymentForms = $paymentFormRepository->toVSelect();
        $categoryRepository = new CategoryRepository();
        $categories = $categoryRepository->toVSelect();

        return view('client.orders.create', compact('clients', 'paymentForms', 'categories'));
    }

    public function store(CreateOrderAction $createOrderAction, OrderRequest $request)
    {
        $data = $request->validated();
        $createOrderAction->execute($data);
        return $this->chooseReturn('success', 'Pedido cadastrado com sucesso', 'client.orders.index');
    }

    public function print(Order $order)
    {
        return view('client.orders.print-order', compact('order'));
    }

    public function setDelivered(Order $order)
    {
        $order->status = OrderStatusEnum::DELIVERED;
        $order->save();
        return $this->chooseReturn('success', 'Alteração no pedido realizada com sucesso!');
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
            ->defaultOrderBy('updated_at', 'desc')
            ->resource(OrderResource::class);
    }
}
