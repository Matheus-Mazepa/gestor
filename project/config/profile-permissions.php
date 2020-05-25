<?php

use App\Enums\UserRolesEnum;

return [
    UserRolesEnum::ADMIN => [
        'dashboard' => ['view',],
        'users_admin' => ['view', 'create', 'update', 'delete',],
        'companies' => ['view', 'create', 'update', 'delete',],
    ],

    UserRolesEnum::CLIENT_ADMIN => [
        'dashboard' => ['view',],
        'categories' => ['view', 'create', 'update', 'delete',],
        'users' => ['view', 'create', 'update', 'delete',],
        'orders' => ['view', 'create', 'update', 'delete'],
        'products' => ['view', 'create', 'update', 'delete',],
        'clients' => ['view', 'create', 'update', 'delete',],
        'financial_schedule' => ['view', 'create', 'update', 'delete',],
    ],
];
