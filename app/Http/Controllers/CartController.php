<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Cart\CartService;
use Exception;
use Illuminate\Support\Str;

class CartController extends Controller
{
    private $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index(Request $request)
    {
        $userId = $request->user()->id;

        try {
            $cart = $this->cartService->findCartByUserId($userId);

            if (empty($cart)) {
                return $this->errorResponse(message: 'Cart of this user not found', code: 404);
            }
            
            return $this->successResponse(message: 'success', data: $cart, code: 200);
        } catch (Exception $e) {
            return $this->errorResponse(message: 'Something went wrong!', code: 500);
        }
    }

    public function store(Request $request)
    {
        $userId = $request->user()->id;
        try {
            $cartId = $this->cartService->findCartIdByUser($userId);
            if (!empty($cartId)) {
                $isItemExists = $this->cartService->isItemExists($cartId, $request->product_id);
            }

            if (!empty($cartId) && !empty($isItemExists)) {
                $request->merge(['cart_id' => $cartId ]);
                $cart = $this->cartService->updateQuantity($request->only([
                    'cart_id',
                    'product_id',
                    'quantity'
                ]));
            } else if (!empty($cartId) && empty($isItemExists)) {
                $request->merge(['cart_id' => $cartId ]);
                $cart = $this->cartService->addNewCartItem($request->only([
                    'cart_id',
                    'product_id',
                    'sku',
                    'barcode',
                    'product_name',
                    'slug',
                    'price',
                    'weight',
                    'quantity',
                    'tax'
                ]));
            } else {
                $request->merge(['cart_id' => '' ]);
                $cart = $this->cartService->saveCart($request->only([
                    'cart_id',
                    'product_id',
                    'sku',
                    'barcode',
                    'product_name',
                    'slug',
                    'price',
                    'weight',
                    'quantity',
                    'tax'
                ]), $userId);
            }

            return $this->successResponse(message: 'success', data: $cart, code: 201);
        } catch (Exception $e) {
            return $this->errorResponse(message: 'Something went wrong!' . $e, code: 500);
        }
    }

    public function update(Request $request)
    {
        try {
            $cart = $this->cartService->findCart($request->cart_id);

            if (empty($cart)) {
                return $this->errorResponse(message: 'Cart not found', code: 404);
            }

            $this->cartService->updateQuantity($request->only(['cart_id', 'product_id', 'quantity']));

            return $this->successResponse(message: 'success', code: 200);
        } catch (Exception $e) {
            return $this->errorResponse(message: 'Something went wrong!', code: 500);
        }
    }

    public function destroy(Request $request)
    {
        try {
            $cart = $this->cartService->findCart($request->cart_id);

            if (empty($cart)) {
                return $this->errorResponse(message: 'Cart not found', code: 404);
            }

            $this->cartService->deleteCartItem($request->only(['cart_id', 'product_id']));

            return $this->successResponse(message: 'success', code: 200);
        } catch (Exception $e) {
            return $this->errorResponse(message: 'Something went wrong', code: 500);
        }
    }
}
