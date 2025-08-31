<?php

namespace App\Enums;

enum PaymentStatusEnum: string
{
    case CREATED = 'created';
    case PENDING = 'pending';
    case PAID = 'paid';
    case FAILED = 'failed';
    case REFUNDED = 'refunded';
}
