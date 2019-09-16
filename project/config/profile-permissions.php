<?php

use App\Enums\UserRolesEnum;

return [
    UserRolesEnum::ADMIN => [
        'users' => ['view', 'create', 'update', 'delete'],
    ],

    UserRolesEnum::CLIENT => [
        'users' => ['view', 'create', 'update', 'delete'],
    ],
];
