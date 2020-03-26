<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\Criterias\Common\Where;
use Illuminate\Http\Request;

use App\Builders\PaginationBuilder;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Repositories\UserRepository;

class UserAdminController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:users_admin view')->only(['index', 'show']);
        $this->middleware('permission:users_admin create')->only(['create', 'store']);
        $this->middleware('permission:users_admin update')->only(['edit', 'update']);
        $this->middleware('permission:users_admin delete')->only('destroy');
    }

    public function index()
    {
        return view('admin.users_admin.index');
    }

    public function create()
    {
        return view('admin.users_admin.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $userRepository = new UserRepository();
        $userRepository->create($data);
        return $this->chooseReturn('success', 'Usuario criado com sucesso', 'admin.users.index');
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
            ->criterias(new Where('is_admin', true))
            ->defaultOrderBy('name')
            ->resource(UserResource::class);

    }
}
