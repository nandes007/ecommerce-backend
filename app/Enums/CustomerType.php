<?php

namespace App\Enums;

enum CustomerType: string
{
    case Silver = 'Silver';
    case Gold = 'Gold';
    case Platinum = 'Platinum';
    case Diamond = 'Diamond';
}