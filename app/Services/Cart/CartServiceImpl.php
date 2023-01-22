<?php

namespace App\Services\Cart;

use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class  CartServiceImpl implements CartService
{
    protected $cart;
    protected $cartItem;

    public function __construct(Cart $cart, CartItem $cartItem)
    {
        $this->cart = $cart;
        $this->cartItem = $cartItem;
    }

    public function findCartByUserId($userId)
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

    public function saveCart($request, $userId)
    {
        $cart = DB::transaction(function () use ($request, $userId) {
            $cartHeader = $this->_saveCart($userId);
            $request['cart_id'] = $cartHeader->id;
            $this->_saveCartItems($request);

            return $this->findCart($cartHeader->id);
        }, 5);

        return $cart;
    }

    public function updateQuantity($request)
    {
        $cartItem = $this->cartItem->where('cart_id', $request['cart_id'])
            ->where('product_id', $request['product_id'])
            ->first();

        $cartItem->quantity = $request['quantity'];

        $cartItem->save();

        $cart = $this->findCart($cartItem->cart_id);

        return $cart;
    }

    public function deleteCartItem($request)
    {
        $cartItem = $this->cartItem->where('cart_id', $request['cart_id'])
            ->where('product_id', $request['product_id'])
            ->first();

        $cartItem->delete();

        return $cartItem;
    }
    
    public function addNewCartItem($request)
    {
        $cartItem = $this->_saveCartItems($request);

        return $this->findCart($cartItem->cart_id);
    }

    public function isItemExists($cartId, $productId)
    {
        $cartItem = $this->cartItem->where('cart_id', $cartId)
            ->where('product_id', $productId)
            ->first();

        return $cartItem;
    }

    public function findCartIdByUser($userId)
    {
        $cart = $this->cart->where('user_id', $userId)->first();

        return $cart->id;
    }

    private function _saveCart($userId)
    {
        $cart = $this->cart->create(['user_id' => $userId]);

        return $cart;
    }

    private function _saveCartItems($request)
    {
        $cartItem = $this->cartItem->create($request);

        return $cartItem;
    }

    public function findCart($id)
    {
        $cart = $this->cart->with('cartItems')->where('id', $id)->get()->map(function ($cart) {
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

}
