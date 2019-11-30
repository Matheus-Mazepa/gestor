<?php

use App\Enums\UserRolesEnum;

return [
    UserRolesEnum::ADMIN => [
        'admin' => ['view', 'create', 'update', 'delete'],
    ],
];
