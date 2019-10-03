<?php

namespace App\Http\Controllers\Client;

use App\Builders\PaginationBuilder;
use App\Enums\UserRolesEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Client\UserRequest;
use App\Http\Resources\Client\UserResource;
use App\Repositories\Criterias\User\FilterByUsers;
use App\Repositories\UserRepository;

class UserController extends Controller
{
    private $userInfoRepository;

    public function __construct()
    {
        $this->repository = new UserRepository();
        $this->resource = UserResource::class;

        $this->middleware('permission:client create')->only(['create', 'store']);
        $this->middleware('permission:client update')->only(['edit', 'update']);
        $this->middleware('permission:client delete')->only(['destroy']);
    }

    public function index()
    {
        return view('client.users.index');
    }

    public function create()
    {
        return view('client.users.create');
    }

    public function store(UserRequest $request)
    {
        $data = $request->all();
        $user = $this->repository->createUser($data);
        $user->assignRole(UserRolesEnum::CLIENT);

        return $this->chooseReturn(
            'success',
            _m('user.success.create'),
            'client.users.index',
            $user->id
        );
    }

    public function edit($id)
    {
        $user = $this->repository->findOrNew($id);
        return view('client.users.edit', compact('user'));
    }

    public function update(UserRequest $request, $id)
    {
        $userData = $request->validated();
        $this->repository->updateUser($id, $userData);

        $message = _m('user.success.update');
        return $this->chooseReturn('success', $message, 'client.users.index', $id);
    }

    public function show($id)
    {
        $user = $this->repository->findOrNew($id);
        return view('client.users.show', compact('user'));
    }

    public function destroy($id)
    {
        try {
            $this->repository->delete($id);

            return $this->chooseReturn(
                'success',
                _m('user.success.destroy'),
                'client.users.index'
            );

        } catch (\Exception $e) {
            return $this->chooseReturn(
                'error',
                _m('user.error.destroy'),
                'client.users.index'
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
