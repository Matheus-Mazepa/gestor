<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\CreateUserAdminAction;
use App\Http\Requests\Admin\UserAdminRequest;
use App\Http\Resources\Admin\UserResource;
use App\Repositories\Criterias\Common\Where;

use App\Builders\PaginationBuilder;
use App\Http\Controllers\Controller;
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

    public function store(CreateUserAdminAction $createUserAdminAction, UserAdminRequest $request)
    {
        $data = $request->validated();
        $createUserAdminAction->execute($data);
        return $this->chooseReturn('success', 'Usuario criado com sucesso', 'admin.users-admin.index');
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
        $pagination->repository(new UserRepository())
            ->criterias(new Where('is_admin', true))
            ->defaultOrderBy('name')
            ->resource(UserResource::class);

    }
}
