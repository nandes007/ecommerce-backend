<?php

namespace App\Services\Cart;

interface CartService
{
    public function saveItems($data);

    public function findByUserId($userId);

    public function findUserCart($userId);

    public function deleteCartItem($userId, $productId);
}