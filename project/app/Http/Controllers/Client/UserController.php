<?php

namespace App\Http\Controllers\Client;

use App\Repositories\Criterias\Common\Where;
use Illuminate\Http\Request;

use App\Builders\PaginationBuilder;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Repositories\UserRepository;

class UserController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:users view')->only(['index', 'show']);
        $this->middleware('permission:users create')->only(['create', 'store']);
        $this->middleware('permission:users update')->only(['edit', 'update']);
        $this->middleware('permission:users delete')->only('destroy');
    }

    public function index()
    {
        return view('client.users.index');
    }

    public function create()
    {
        return view('client.users.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $userRepository = new UserRepository();
        $userRepository->create($data);
        return $this->chooseReturn('success', 'Usuario criado com sucesso', 'client.users.index');
    }

    /**
     * Configura a paginação.
     *
     * @param PaginationBuilder $pagination
     * @return void
     */
    protected function getPagination($pagination)
    {
        $pagination->repository(new UserRepository())
            ->defaultOrderBy('name')
            ->criterias(new Where('is_admin', false))
            ->resource(UserResource::class);

    }
}
