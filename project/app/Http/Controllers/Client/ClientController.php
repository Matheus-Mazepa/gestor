<?php

namespace App\Http\Controllers\Client;

use App\Actions\Client\CreateClientAction;
use App\Http\Requests\Client\ClientRequest;
use App\Http\Resources\Client\ClientResource;
use App\Models\Client;
use App\Repositories\ClientRepository;

use App\Builders\PaginationBuilder;
use App\Http\Controllers\Controller;

class ClientController extends Controller
{
    /**
     * Show the application dashboard.
     *
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

    public function store(ClientRequest $request, CreateClientAction $createClientAction)
    {
        $data = $request->validated();

        $createClientAction->execute($data);

        return $this->chooseReturn('success', 'Cliente criado com sucesso', 'client.clients.index');
    }

    public function edit(Client $client)
    {
        $client->load('addresses');
        return view('client.clients.edit', compact('client'));
    }

    public function update($id, ClientRequest $request)
    {
        $data = $request->validated();
        dd($data);
        return $this->chooseReturn('success', 'Cliente atualizado com sucesso', 'client.clients.index');
    }

    public function destroy($id) {
        $clientRepository = new ClientRepository();
        $clientRepository->delete($id);

        return $this->chooseReturn('success', 'Cliente removido com sucesso');
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
