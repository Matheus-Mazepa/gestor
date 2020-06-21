<?php

namespace App\Actions\Admin;

use App\Models\User;
use App\Enums\UserRolesEnum;
use App\Repositories\UserRepository;

class EditUserCompanyAction
{
    public function execute($data, $companyId, $userId) : User
    {
        $data['company_id'] = $companyId;
        $userRepository = new UserRepository();
        $user = $userRepository->updateUser($userId, $data);

        return $user;
    }
}
