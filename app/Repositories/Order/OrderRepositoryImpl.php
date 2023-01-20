<?php

namespace App\Repositories\Order;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Services\Cart\CartService;
use Illuminate\Support\Str;

class OrderRepositoryImpl implements OrderRepository
{
    protected $order;
    protected $orderItem;
    protected $cartService;
    // protected $orderStatus;
    // protected $paymentStatus;

    public function __construct(Order $order, OrderItem $orderItem, CartService $cartService)
    {
        $this->order = $order;
        $this->orderItem = $orderItem;
        $this->cartService = $cartService;
        // $this->orderStatus = $orderStatus;
        // $this->paymentStatus = $paymentStatus;
    }

    public function saveItems($carts, $user, $cost)
    {
        $data = [];
        $data["carts"] = $carts;
        $data["user"] = $user;
        $data["cost"] = $cost;
        $cartItems = $carts["items"];
        $order = DB::transaction(function () use ($data, $cartItems) {
            $order = $this->_saveOrder($data);
            $this->_saveOrderItems($order, $cartItems);
            $this->cartService->delete($data["carts"]["id"]);

            return $order;
        });

        return $order;
    }

    public function findByUserId($userId)
    {
        $order = $this->order->with('orderItems')->where('user_id', $userId)->get()->map(function ($order) {
            return [
                'id' => $order->id,
                'userId' => $order->user_id,
                'status' => $order->status,
                'order_date' => $order->order_date,
                'payment_status' => $order->payment_status,
                'grand_total' => $order->grand_total,
                'items' => $order->orderItems->map(function ($items) {
                    return [
                        'productId' => $items->product_id,
                        'price' => $items->price,
                        'sub_total' => $items->sub_total
                    ];
                })
            ];
        });

        return $order;
    }

    private function _saveOrder($data)
    {
        $status = 'Created';
        $order_date = date('Y-m-d H:i:s');
        $payment_due = (new \DateTime($order_date))->modify('+7 day')->format('Y-m-d H:i:s');
        $payment_status = 'Unpaid';
        $total_gross = $this->_getTotalCart($data["carts"]["items"]);
        $tax_amount = $total_gross * (11/100);
        $tax_percent = 11;
        $discount_amout = 0;
        $discount_percent = 0;
        $shipping_cost = $data["cost"]["cost"][0]["value"];
        $grand_total = ($total_gross + $tax_amount + $shipping_cost) - $discount_amout;
        $note = '';
        $customer_fullname = $data["user"]->name;
        $customer_address = $data["user"]->address;
        $customer_phone = $data["user"]->phone_number;
        $customer_email = $data["user"]->email;
        $customer_city_id = $data["user"]->city_id;
        $customer_province_id = $data["user"]->province_id;
        $customer_postalcode = $data["user"]->postalcode;
        $shipping_courier = $data["cost"]["service"];
        $shipping_service_name = $data["cost"]["description"];

        $orderParams = [
            'id' => Str::uuid(),
            'user_id' => $data["user"]->id,
            'status' => $status,
            'order_date' => $order_date,
            'payment_due' => $payment_due,
            'payment_status' => $payment_status,
            'total_gross' => $total_gross,
            'tax_amount' => $tax_amount,
            'tax_percent' => $tax_percent,
            'discount_amount' => $discount_amout,
            'discount_percent' => $discount_percent,
            'shipping_cost' => $shipping_cost,
            'grand_total' => $grand_total,
            'note' => $note,
            'customer_fullname' => $customer_fullname,
            'customer_address' => $customer_address,
            'customer_phone' => $customer_phone,
            'customer_email' => $customer_email,
            'customer_city_id' => $customer_city_id,
            'customer_province_id' => $customer_province_id,
            'customer_postalcode' => $customer_postalcode,
            'shipping_courier' => $shipping_courier,
            'shipping_service_name' => $shipping_service_name
        ];

        // return Order::create($orderParams);
        return $this->order->create($orderParams);
    }

    private function _saveOrderItems($order, $items)
    {
        if ($order && $items) {
            foreach ($items as $item) {
                $product_id = $item["productId"];
                $quantity = $item["quantity"];
                $weight = $item["weight"];
                $avg_cost = $item['price'];
                $price = $item['price'];
                $tax_amount = $item["price"] * (11/100);
                $discount_amout = 0;
                
                $orderItemsParam = [
                    'order_id' => $order->id,
                    'product_id' => $product_id,
                    'qty' => $quantity,
                    'weight' => $weight,
                    'avg_cost' => $avg_cost,
                    'price' => $price,
                    'tax_amount' => $tax_amount,
                    'tax_percent' => 11,
                    'discount_amount' => $discount_amout,
                    'discount_percent' => 0,
                    'gross' => $price + $tax_amount,
                    'sub_total' => ($price + $tax_amount) - $discount_amout 
                ];

                $orderItem = $this->orderItem->create($orderItemsParam);
            }
        }
    }

    private function _getTotalCart($arr)
    {
        $total = 0;

        foreach ($arr as $item) {
            $total += $item["price"] * $item["quantity"];
        }

        return $total;
    }
}