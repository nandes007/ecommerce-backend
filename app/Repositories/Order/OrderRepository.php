<?php

namespace App\Repositories\Order;

interface OrderRepository
{
    public function saveItems($carts, $user, $cost);
}