<?php

namespace App\Http\Controllers\Admin\Users;

use App\Builders\PaginationBuilder;
use App\Enums\UserRolesEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Users\UserAdminRequest;
use App\Http\Resources\Users\UserAdminResource;
use App\Repositories\Criterias\User\FilterByUsers;
use App\Repositories\UserRepository;
use Illuminate\Http\Response;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->repository = new UserRepository();
        $this->resource = UserAdminResource::class;

        $this->middleware('permission:users create')->only(['create', 'store']);
        $this->middleware('permission:users update')->only(['edit', 'update']);
        $this->middleware('permission:users delete')->only(['destroy']);
    }

    public function index()
    {
        return view('admin.users.admin.index');
    }

    public function create()
    {
        return view('admin.users.admin.create');
    }

    public function store(UserAdminRequest $request)
    {
        $data = $request->all();
        $user = $this->repository->createUser($data);
        $user->assignRole(UserRolesEnum::ADMIN);

        $message = _m('user.success.create');
        return $this->chooseReturn('success', $message, 'admin.users.admin.index', $user->id);
    }

    public function edit($id)
    {
        try {
            $user = $this->repository->findOrFail($id);
            return view('admin.users.admin.edit', compact('user'));
        } catch (\Exception $e) {
            flash()->error(__('flash.user.error.not_found'));
            return redirect(route('admin.users.admin.index'), Response::HTTP_PERMANENTLY_REDIRECT);
        }
    }

    public function update(UserAdminRequest $request, $id)
    {
        $userData = $request->validated([
            'name',
            'email',
            'password',
        ]);

        $this->repository->updateUser($id, $userData);

        $message = _m('user.success.update');
        return $this->chooseReturn('success', $message, 'admin.users.admin.index', $id);
    }

    public function show($id)
    {
        try {
            $user = $this->repository->findOrFail($id);
            return view('admin.users.admin.show', compact('user'));
        } catch (\Exception $e) {
            flash()->error(__('flash.user.error.not_found'));
            return redirect(route('admin.users.admin.index'), Response::HTTP_PERMANENTLY_REDIRECT);
        }

    }

    public function destroy($id)
    {
        try {
            $this->repository->delete($id);
            return $this->chooseReturn('success', _m('user.success.destroy'), 'admin.users.admin.index');
        } catch (\Exception $e) {
            return $this->chooseReturn('error', _m('user.error.destroy'), 'admin.users.admin.index');
        }
    }

    public function pagination()
    {
        $pagination = new PaginationBuilder();

        $pagination->repository($this->repository)
            ->criterias(new FilterByUsers(UserRolesEnum::ADMIN))
            ->defaultOrderBy('name')
            ->resource($this->resource);

        return $pagination->build();
    }
}
