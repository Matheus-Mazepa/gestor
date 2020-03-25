<?php

use App\Enums\UserRolesEnum;

return [
    UserRolesEnum::ADMIN => [
        'users' => ['view', 'create', 'update', 'delete',],
        'admin_users' => ['view', 'create', 'update', 'delete',],
    ],

    UserRolesEnum::CLIENT_ADMIN => [
        'users' => ['view', 'create', 'update', 'delete',],
        'orders' => ['view', 'create', 'update', 'delete'],
        'products' => ['view', 'create', 'update', 'delete',],
        'clients' => ['view', 'create', 'update', 'delete',],
        'financial_schedule' => ['view', 'create', 'update', 'delete',],
    ],
];
