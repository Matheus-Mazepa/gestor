<?php

namespace App\Enums;

abstract class OrderStatusEnum extends Enum
{
    const WAITING_DELIVERY = 'waiting_delivery';
    const DELIVERED = 'delivered';
}
