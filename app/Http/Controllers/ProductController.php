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
                        ->select('id', 'sku', 'barcode', 'product_name', 'slug', 'tax', 'avgcost', 'price', 'weight', 'description')
                        ->get();

        return $this->output(status: true, data: $data, code: 200);
    }
}
