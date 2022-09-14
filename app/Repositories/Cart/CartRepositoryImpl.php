<?php

namespace App\Repositories\Cart;

use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\DB;

class CartRepositoryImpl implements CartRepository
{
    protected $cart;
    protected $cartItem;

    public function __construct(Cart $cart, CartItem $cartItem)
    {
        $this->cart = $cart;
        $this->cartItem = $cartItem;
    }

    public function saveItems($data)
    {
        $cart = DB::transaction(function () use ($data) {
            $cart = $this->_saveCart($data);
            $this->_saveCartItem($cart, $data);

            return $cart;
        });
        
        return $cart;
    }

    private function _saveCart($data)
    {
        $cart = new $this->cart;
        $cart->id = $data['id'];
        $cart->user_id = $data['user_id'];
        $cart->status = $data['status'];

        $cart->save();

        return $cart;
    }

    private function _saveCartItem($cart, $data)
    {
        $cartItem = new $this->cartItem;
        $cartItem->cart_id = $cart->id;
        $cartItem->product_id = $data['items']['id'];
        $cartItem->product_name = $data['items']['product_name'];
        $cartItem->slug = $data['items']['slug'];
        $cartItem->quantity = $data['items']['quantity'];
        $cartItem->tax = $data['items']['tax'];
        $cartItem->price = $data['items']['price'];
        $cartItem->weight = $data['items']['weight'];
        
        $cartItem->save();

        return $cartItem;
    }

    public function findByUserId($userId)
    {
        $cart = $this->cart->with('cartItems')->where('user_id', $userId)->get()->map(function ($cart) {
            return [
                'id' => $cart->id,
                'userId' => $cart->user_id,
                'status' => $cart->status,
                'items' => $cart->cartItems->map(function ($items) {
                    return [
                        'productId' => $items->product_id,
                        'product_name' => $items->product_name,
                        'slug' => $items->slug,
                        'quantity' => $items->quantity,
                        'price' => $items->price,
                        'tax' => $items->tax,
                        'weight' => $items->tax,
                    ];
                })
            ];
        });

        return $cart;
    }

    public function findUserCart($userId)
    {
        $cart = $this->cart->with('cartItems')->where('user_id', $userId)->first();
        
        return $cart->cartItems;
    }

    public function findIdCart($userId)
    {
        $cartId = $this->findIdCartByUserId($userId);

        return $cartId;
    }

    public function isItemExist($cartId, $productId)
    {
        $cartItem = $this->cartItem->where('cart_id', $cartId)
                ->where('product_id', $productId)
                ->first();

        return $cartItem;
    }

    private function findIdCartByUserId($userId)
    {
        $cart = $this->cart->where('user_id', $userId)->first();
        
        return $cart;
    }

    public function updateQuantity($cartId, $productId, $quantity)
    {   
        $cartItem = $this->cartItem->where('cart_id', $cartId)
                ->where('product_id', $productId)
                ->first();
        
        $cartItem->quantity = $quantity;

        $cartItem->save();

        return $cartItem;
    }

    public function addCartItem($data, $userId)
    {
        $cart = $this->findIdCartByUserId($userId);

        return $this->_saveCartItem($cart, $data);
    }

    public function deleteCartItem($cartId, $productId)
    {
        $cartItem = $this->cartItem->where('cart_id', $cartId)
                ->where('product_id', $productId)
                ->first();

        $cartItem->delete();

        return $cartItem;
    }

    public function delete($cartId)
    {
        $cart = $this->cart->find($cartId);
        $cart->cartItems()->delete();
        $cart->delete();
        
        return [];
    }

    public function format($cart)
    {
        return [
            'id' => $cart->id,
            'user_id' => $cart->user_id,
            'status' => $cart->status,
            'items' => json_decode($cart->items)
        ];
    }
}