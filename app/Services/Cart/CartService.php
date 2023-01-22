<?php

namespace App\Services\Cart;

interface CartService
{
    public function findCartByUserId($userId);

    public function saveCart($request, $userId);

    public function findCart($id);

    public function updateQuantity($request);

    public function deleteCartItem($request);

    public function addNewCartItem($request);

    public function isItemExists($cartId, $productId);

    public function findCartIdByUser($userId);
    
}
