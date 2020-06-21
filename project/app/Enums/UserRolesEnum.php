<?php

namespace App\Enums;

abstract class UserRolesEnum extends Enum
{
    const ADMIN = 'Administrador';
    const CLIENT_ADMIN = 'Administrador de empresa';
    const CLIENT_SALESMAN = 'Vendedor';
}
