<?php

namespace App\Http\Controllers\Admin\Users;

use App\Builders\PaginationBuilder;
use App\Enums\UserRolesEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Users\ClientRequest;
use App\Http\Resources\Admin\ClientResource;
use App\Repositories\Criterias\User\FilterByUsers;
use App\Repositories\UserRepository;

class ClientController extends Controller
{
    private $userInfoRepository;

    public function __construct()
    {
        $this->repository = new UserRepository();
        $this->resource = ClientResource::class;

        $this->middleware('permission:client create')->only(['create', 'store']);
        $this->middleware('permission:client update')->only(['edit', 'update']);
        $this->middleware('permission:client delete')->only(['destroy']);
    }

    public function index()
    {
        return view('admin.users.client.index');
    }

    public function create()
    {
        return view('admin.users.client.create');
    }

    public function store(ClientRequest $request)
    {
        $data = $request->all();
        $user = $this->repository->createUser($data);
        $user->assignRole(UserRolesEnum::CLIENT);

        return $this->chooseReturn(
            'success',
            _m('user.success.create'),
            'admin.users.client.index',
            $user->id
        );
    }

    public function edit($id)
    {
        $user = $this->repository->findOrNew($id);
        return view('admin.users.client.edit', compact('user'));
    }

    public function update(ClientRequest $request, $id)
    {
        $userData = $request->validated();
        $this->repository->updateUser($id, $userData);

        $message = _m('user.success.update');
        return $this->chooseReturn('success', $message, 'admin.users.client.index', $id);
    }

    public function show($id)
    {
        $user = $this->repository->findOrNew($id);
        return view('admin.users.client.show', compact('user'));
    }

    public function destroy($id)
    {
        try {
            $this->repository->delete($id);

            return $this->chooseReturn(
                'success',
                _m('user.success.destroy'),
                'admin.users.client.index'
            );

        } catch (\Exception $e) {
            return $this->chooseReturn(
                'error',
                _m('user.error.destroy'),
                'admin.users.client.index'
            );
        }
    }

    public function pagination()
    {
        $pagination = new PaginationBuilder();

        $pagination->repository($this->repository)
            ->criterias([
                new FilterByUsers(UserRolesEnum::CLIENT)
            ])
            ->defaultOrderBy('name')
            ->resource($this->resource);

        return $pagination->build();
    }
}
