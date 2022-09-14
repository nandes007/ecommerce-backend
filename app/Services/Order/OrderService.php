<?php

namespace App\Services\Order;

interface OrderService
{
    public function saveItems($carts, $user, $cost);
}