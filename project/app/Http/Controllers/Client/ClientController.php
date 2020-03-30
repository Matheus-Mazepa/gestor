<?php

namespace App\Http\Controllers\Client;

use App\Http\Requests\Client\ClientRequest;
use App\Http\Resources\Client\ClientResource;
use App\Repositories\ClientRepository;

use App\Builders\PaginationBuilder;
use App\Http\Controllers\Controller;

class ClientController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:clients view')->only(['index', 'show']);
        $this->middleware('permission:clients create')->only(['create', 'store']);
        $this->middleware('permission:clients update')->only(['edit', 'update']);
        $this->middleware('permission:clients delete')->only('destroy');
    }

    public function index()
    {
        return view('client.clients.index');
    }

    public function create()
    {
        return view('client.clients.create');
    }

    public function store(ClientRequest $request)
    {
        $data = $request->validated();
        dd($data);
        $clientRepository = new ClientRepository();
        $clientRepository->create($data);
        return $this->chooseReturn('success', 'Cliente criado com sucesso', 'client.clients.index');
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
        $pagination->repository(new ClientRepository())
            ->defaultOrderBy('name')
            ->resource(ClientResource::class);

    }
}
