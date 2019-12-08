<?php

use App\Enums\UserRolesEnum;

return [
    UserRolesEnum::ADMIN => [
        'admin' => ['view', 'create', 'update', 'delete'],
        'orders' => ['view', 'create', 'update', 'delete'],
    ],
];
