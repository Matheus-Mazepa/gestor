<?php

namespace App\Http\Controllers\Admin\Users;

use App\Builders\PaginationBuilder;
use App\Enums\UserRolesEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Users\AdminRequest;
use App\Http\Resources\Admin\AdminResource;
use App\Repositories\Criterias\User\FilterByUsers;
use App\Repositories\UserRepository;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->repository = new UserRepository();
        $this->resource = AdminResource::class;

        $this->middleware('permission:admin create')->only(['create', 'store']);
        $this->middleware('permission:admin update')->only(['edit', 'update']);
        $this->middleware('permission:admin delete')->only(['destroy']);
    }

    public function index()
    {
        return view('admin.users.admin.index');
    }

    public function create()
    {
        return view('admin.users.admin.create');
    }

    public function store(AdminRequest $request)
    {
        $data = $request->all();
        $user = $this->repository->createUser($data);
        $user->assignRole(UserRolesEnum::ADMIN);

        return $this->chooseReturn(
            'success',
            _m('user.success.create'),
            'admin.users.admin.index',
            $user->id
        );
    }

    public function edit($id)
    {
        $user = $this->repository->findOrNew($id);
        return view('admin.users.admin.edit', compact('user'));
    }

    public function update(AdminRequest $request, $id)
    {
        $userData = $request->validated();
        $this->repository->updateUser($id, $userData);

        $message = _m('user.success.update');
        return $this->chooseReturn('success', $message, 'admin.users.admin.index', $id);
    }

    public function show($id)
    {
        $user = $this->repository->findOrNew($id);
        return view('admin.users.admin.show', compact('user'));
    }

    public function destroy($id)
    {
        try {
            $this->repository->delete($id);

            return $this->chooseReturn(
                'success',
                _m('user.success.destroy'),
                'admin.users.admin.index'
            );

        } catch (\Exception $e) {
            return $this->chooseReturn(
                'error',
                _m('user.error.destroy'),
                'admin.users.admin.index'
            );
        }
    }

    public function pagination()
    {
        $pagination = new PaginationBuilder();

        $pagination->repository($this->repository)
            ->criterias([
                new FilterByUsers(UserRolesEnum::ADMIN)
            ])
            ->defaultOrderBy('name')
            ->resource($this->resource);

        return $pagination->build();
    }
}
