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
        $result = $this->cartService->findUserCart($userId);
        // $result = $this->cartService->updateQuantity($userId);

        return response()->json($result);
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
        } catch (Exception $e) {
            $result = [];
            $statusCode = 500;
            $message = $e->getMessage();
        }

        return $this->output(data: $result, message: $message, code:$statusCode);
    }

    public function find(Request $request)
    {
        $userId = $request->user()->id;

        try {
            $result = $this->cartService->findByUserId($userId);
            $statusCode = 200;
            $message = 'success';
        } catch (Exception $e) {
            $result = [];
            $statusCode = 500;
            $message = $e->getMessage();
        }

        return $this->output(data: $result, message: $message, code:$statusCode);
    }

    public function destroy(Request $request)
    {
        $userId = $request->user()->id;
        $productId = $request->input('productId');
        try {
            $result = $this->cartService->deleteCartItem($userId, $productId);
            $statusCode = 204;
            $message = 'success';
        } catch (Exception $e) {
            $result = [];
            $statusCode = 500;
            $message = $e->getMessage();
        }

        return $this->output(data: $result, message: $message, code:$statusCode);
    }
}
