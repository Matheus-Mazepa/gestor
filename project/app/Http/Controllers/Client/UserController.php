<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;

use App\Http\Requests\Client\UserRequest;
use App\Http\Resources\Client\User as UserResource;

class UserController extends Controller
{
    public function index()
    {
        return view('client.users.index');
    }

    public function create()
    {
        return view('client.users.create');
    }

    public function store(UserRequest $request, UserRepository $userRepository)
    {
        $data = $request->all();
        $userRepository->createUser($data);

        $message = _m('user.success.create');
        return $this->chooseReturn('success', $message, 'client.users.index');
    }

    public function edit(UserRepository $userRepository, $id)
    {
        $user = $userRepository->find($id);
        return view('client.users.edit', compact('user'));
    }

    public function update(UserRequest $request, UserRepository $userRepository, $id)
    {
        $data = $request->all();
        $userRepository->updateUser($id, $data);

        $message = _m('user.success.update');
        return $this->chooseReturn('success', $message, 'client.users.index');
    }

    public function show(UserRepository $userRepository, $id)
    {
        $user = $userRepository->find($id);

        return view('client.users.show', compact('user'));
    }

    public function destroy(UserRepository $userRepository, $id)
    {
        try {
            $userRepository->delete($id);
            return $this->chooseReturn('success', _m('user.success.destroy'));
        } catch (\Exception $e) {
            return $this->chooseReturn('error', _m('user.error.destroy'));
        }
    }

    protected function getPagination($pagination)
    {
        $pagination->repository(UserRepository::class)
            ->resource(UserResource::class);
    }
}
