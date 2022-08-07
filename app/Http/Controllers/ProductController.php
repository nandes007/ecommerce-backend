<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $data = Product::with(['productImages' => function ($query) {
                            $query->select('id', 'product_id', 'path');
                        }])
                        ->select('id', 'product_name', 'slug', 'price', 'weight', 'stock', 'description')
                        ->get();

        return $this->output(status: 'success', data: $data, code: 200);
    }
}
