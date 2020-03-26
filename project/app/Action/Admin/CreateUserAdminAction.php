<?php

namespace App\Actions\Admin;

use App\Models\User;
use App\Enums\UserRolesEnum;
use App\Repositories\UserRepository;

class CreateUserAdminAction
{
    public function execute($data) : User
    {
        $data['is_admin'] = true;
        $userRepository = new UserRepository();
        $user = $userRepository->create($data);
        $user->assignRole(UserRolesEnum::ADMIN);
        return $user;
    }
}
