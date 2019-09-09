<?php

use App\Enums\UserRolesEnum;

return [
    UserRolesEnum::ADMIN => [
        'users' => [
            'index',
            'create',
            'edit',
            'destroy'
        ],
    ],

    UserRolesEnum::CLIENT => [
        'users' => [
            'index',
            'create',
            'edit',
            'destroy'
        ],
    ],
];
