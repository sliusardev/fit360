<?php

namespace App\Enums;

enum PaymentProviderEnum: string
{
    case WAYFORPAY = 'wayforpay';
    case MONOBANK = 'monobank';
    case LIQPAY = 'liqpay';
}
