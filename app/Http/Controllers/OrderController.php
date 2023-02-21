<?php

namespace App\Http\Controllers;

use App\Services\Cart\CartService;
use App\Services\Order\OrderService;
use Exception;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $cartService;
    protected $orderService;

    public function __construct(CartService $cartService, OrderService $orderService)
    {
        $this->cartService = $cartService;
        $this->orderService = $orderService;
    }

    public function index(Request $request)
    {
        $userId = $request->user()->id;

        try {
            $result = $this->orderService->findByUserId($userId);
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

    public function store(Request $request)
    {
        $user = $request->user();
        $carts = $this->cartService->findByUserId($user->id);
        $cost = $request->only('description', 'service', 'cost');

        try {
            $result = $this->orderService->saveItems($carts[0], $user, $cost);
            $statusCode = 201;
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
