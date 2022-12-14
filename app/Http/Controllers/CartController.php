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

    public function store(Request $request)
    {
        $userId = $request->user()->id;
        $items = $request->all();
        
        $data = [
            'id' => Str::uuid(),
            'user_id' => $userId,
            'items' => $items,
            'status' => false
        ];

        try {
            $result = [];
            $saveCart = $this->cartService->saveItems($data);
            if ($saveCart) {
                $result = $this->cartService->findByUserId($userId);
            }
            $statusCode = 200;
            $message = 'success';
            $status = true;
        } catch (Exception $e) {
            $result = [];
            $statusCode = 500;
            $message = $e->getMessage();
            $status = false;
        }

        return $this->output(status: $status, data: $result, message: $message, code:$statusCode);
    }

    public function update(Request $request)
    {
        $data = [
            'cartId' => $request->input('cartId'),
            'productId' => $request->input('productId'),
            'quantity' => $request->input('quantity'),
        ];

        try {
            $this->cartService->updateQuantity($data['cartId'], $data['productId'], $data['quantity']);
            $statusCode = 200;
            $message = 'success';
            $status = true;
        } catch (Exception $e) {
            $statusCode = 500;
            $message = $e->getMessage();
            $status = false;
        }

        return $this->output(status: $status, message: $message, code:$statusCode);
    }

    public function find(Request $request)
    {
        $userId = $request->user()->id;

        try {
            $result = $this->cartService->findByUserId($userId);
            $statusCode = 200;
            $message = 'success';
            $status = true;
        } catch (Exception $e) {
            $result = [];
            $statusCode = 500;
            $message = $e->getMessage();
            $status = false;
        }

        return $this->output(status: $status, data: $result, message: $message, code:$statusCode);
    }

    public function destroy(Request $request)
    {
        $userId = $request->user()->id;
        $productId = $request->input('productId');
        try {
            $result = $this->cartService->deleteCartItem($userId, $productId);
            $statusCode = 204;
            $message = 'success';
            $status = true;
        } catch (Exception $e) {
            $result = [];
            $statusCode = 500;
            $message = $e->getMessage();
            $status = false;
        }

        return $this->output(status: $status, data: $result, message: $message, code:$statusCode);
    }
}
