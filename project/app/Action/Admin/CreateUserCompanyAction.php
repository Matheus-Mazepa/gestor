<?php

namespace App\Action\Admin;

use App\Models\User;
use App\Enums\UserRolesEnum;
use App\Repositories\UserRepository;

class CreateUserCompanyAction
{
    public function execute($data, $companyId) : User
    {
        $data['company_id'] = $companyId;
        $userRepository = new UserRepository();
        $user = $userRepository->createUser($data);
        $user->assignRole(UserRolesEnum::CLIENT_ADMIN);
        return $user;
    }
}
