<?php

namespace App\Services\Order;

use App\Repositories\Order\OrderRepository;

class OrderServiceImpl implements OrderService
{
    protected $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function saveItems($carts, $user, $cost)
    {
        return $this->orderRepository->saveItems($carts, $user, $cost);
    }

    public function findByUserId($userId)
    {
        return $this->orderRepository->findByUserId($userId);
    }
}