<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductRequest;
use App\Services\Admin\Product\ProductService;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function __construct(protected ProductService $productService)
    {
    }

    public function index()
    {
        try {
            $products = $this->productService->getAllProduct();
            return $this->successResponse(message: 'success', data: $products, code: 200);
        } catch (\Exception $e) {
            return $this->errorResponse(message: 'Something went wrong', code: 500);
        }
    }

    public function store(ProductRequest $request)
    {
        $request->merge([
            'slug' => Str::slug($request->product_name),
            'avgcost' => $request->unitprice,
            'lastcost' => $request->unitprice,
            'price_old' => $request->price
        ]);

        try {
            $product = $this->productService->storeProduct($request->all());
            return $this->successResponse(message: 'success', data: $product, code: 201);
        } catch (\Exception $e) {
            return $this->errorResponse(message: 'Something went wrong' . $e, code: 500);
        }
    }

    public function show($id)
    {
        try {
            $product = $this->productService->showProduct($id);
            if (empty($product)) {
                return $this->errorResponse(message: 'Product not found!', code: 404);
            }

            return $this->successResponse(message: 'success', data: $product, code: 200);
        } catch (\Exception $e) {
            return $this->errorResponse(message: 'Something went wrong', code: 500);
        }
    }

    public function update(ProductRequest $request, $id)
    {
        try {
            $product = $this->productService->showProduct($id);
            if (empty($product)) {
                return $this->errorResponse(message: 'Product not found!', code: 404);
            }
            $this->productService->updateProduct($request->all(), $id);
            return $this->successResponse(message: 'success', code: 200);
        } catch (\Exception $e) {
            return $this->errorResponse(message: 'Something went wrong', code: 500);
        }
    }

    public function destroy($id)
    {
        try {
            $product = $this->productService->showProduct($id);
            if (empty($product)) {
                return $this->errorResponse(message: 'Product not found!', code: 404);
            }
            $this->productService->deleteProduct($id);
            return $this->successResponse(message: 'success', code: 200);
        } catch (\Exception $e) {
            return $this->errorResponse(message: 'Something went wrong!', code: 500);
        }
    }
}
