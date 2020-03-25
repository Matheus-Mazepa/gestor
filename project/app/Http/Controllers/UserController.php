<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

use App\Builders\PaginationBuilder;
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
    }

    public function index()
    {
        return view('users.index');
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $userRepository = new UserRepository();
        $userRepository->create($data);
        return $this->chooseReturn('success', 'Usuario criado com sucesso', 'users.index');
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
            ->resource(UserResource::class);

    }
}
