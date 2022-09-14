<?php

namespace App\Enums;

enum PaymentStatus: string
{
    case Paid = 'Paid';
    case Unpaid = 'Unpaid';
}