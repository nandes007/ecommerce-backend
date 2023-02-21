<?php

namespace App\Enums;

enum OrderStatus: string
{
    case Created = 'Created';
    case Confirmed = 'Confirmed';
    case Delivered = 'Delivered';
    case Completed = 'Completed';
    case Cancelled = 'Cancelled';
}