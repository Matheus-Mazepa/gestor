<?php

use App\Enums\UserRolesEnum;

return [
    UserRolesEnum::ADMIN => [
        'admin' => ['view', 'create', 'update', 'delete'],
        'client' => ['view', 'create', 'update', 'delete'],
    ],

    UserRolesEnum::CLIENT => [
        'client' => ['view', 'create', 'update', 'delete'],
    ],
];
