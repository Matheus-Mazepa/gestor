<?php

namespace App\Enums;

abstract class UserRolesEnum extends Enum
{
    const ADMIN = 'admin';
    const CLIENT = 'client_admin';
    const CLIENT_ADMIN = 'client_admin';
    const CLIENT_SALESMAN = 'client_salesman';
}
