<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;

class CartController extends Controller
{
    public function saveItems(Request $request)
    {
        $data = json_encode($request->all());
        $res = array();
        $cart = new Cart();
        $cart->user_id = 1;
        $cart->items = $data;
        $cart->status = false;
        $cart->save();

        if ($cart != null) {
            $res["id"] = $cart->id;
            $res["user_id"] = $cart->user_id;
            $res["status"] = $cart->status;
            $res["items"] = json_decode($cart->items);
        }

        return $this->output(status: 'success', data: $res, code: 200);
    }
}
