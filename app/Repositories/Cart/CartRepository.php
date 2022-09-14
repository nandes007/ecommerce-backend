<?php

namespace App\Repositories\Cart;

interface CartRepository
{
    public function saveItems($data);

    public function findByUserId($userId);

    public function findUserCart($userId);

    public function findIdCart($userId);

    public function isItemExist($cartId, $productId);

    public function updateQuantity($cartId, $productId, $quantity);

    public function addCartItem($data, $userId);

    public function deleteCartItem($cartId, $productId);

    public function delete($cartId);
}