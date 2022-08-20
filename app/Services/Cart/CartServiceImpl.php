<?php

namespace App\Services\Cart;

use App\Repositories\Cart\CartRepository;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class CartServiceImpl implements CartService
{
    protected $cartRepository;

    public function __construct(CartRepository $cartRepository)
    {
        $this->cartRepository = $cartRepository;
    }

    public function saveItems($data)
    {
        $validator = Validator::make($data, [
            'id' => ['required'],
            'user_id' => ['required'],
            'items' => ['required']
        ]);

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }
        
        $isExist = $this->cartRepository->findIdCart($data['user_id']);
        
        if (!$isExist) {
            return $this->cartRepository->saveItems($data);
        } else {
            $isItemExist = $this->cartRepository->isItemExist($isExist->id, $data['items']['id']);
            if ($isExist && $isItemExist) {
                return $this->cartRepository->updateQuantity($isExist->id, $data['items']['id'], $data['items']['quantity']);
            } else {
                return $this->cartRepository->addCartItem($data, $data['user_id']);
            }
        }
        
        return [];
    }

    public function findByUserId($userId)
    {
        return $this->cartRepository->findByUserId($userId);
    }

    public function findUserCart($userId)
    {
        return $this->cartRepository->findUserCart($userId);
    }

    public function deleteCartItem($userId, $productId)
    {
        $cartId = $this->cartRepository->findIdCart($userId);
        if ($cartId) {
            $isItemExist = $this->cartRepository->isItemExist($cartId->id, $productId);
            if ($isItemExist) {
                return $this->cartRepository->deleteCartItem($cartId->id, $productId);
            } else {
                return [];
            }
        }

        return [];
    }

    public function updateQuantity($cartId, $productId, $quantity)
    {
        return $this->cartRepository->updateQuantity($cartId, $productId, $quantity);
    }
}