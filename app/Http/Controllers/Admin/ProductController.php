<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductRequest;
use App\Services\Admin\Product\ProductService;
use App\Services\Helper\Image\ImageService;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;

class ProductController extends Controller
{
    public function __construct(protected ProductService $productService, protected ImageService $imageService)
    {
    }

    public function index()
    {
        try {
            $products = $this->productService->getAll();
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

        if ($request->hasFile('images')) {
            $images = $request->file('images');
            $imageResized = $this->imageService->resizeImage($images);
            $imageUploaded = $this->imageService->uploadImage($imageResized);
            $request->merge([
                'product_images' => $imageUploaded
            ]);
        }

        try {
            $product = $this->productService->save($request->all(), $imageUploaded);
            return $this->successResponse(message: 'success', data: $product, code: 201);
        } catch (\Exception $e) {
            return $this->errorResponse(message: 'Something went wrong' . $e, code: 500);
        }
    }

    public function show($id)
    {
        try {
            $product = $this->productService->find($id);
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
            $product = $this->productService->find($id);
            if (empty($product)) {
                return $this->errorResponse(message: 'Product not found!', code: 404);
            }
            $this->productService->update($request->all(), $id);
            return $this->successResponse(message: 'success', code: 200);
        } catch (\Exception $e) {
            return $this->errorResponse(message: 'Something went wrong'.$e, code: 500);
        }
    }

    public function destroy($id)
    {
        try {
            $product = $this->productService->find($id);
            if (empty($product)) {
                return $this->errorResponse(message: 'Product not found!', code: 404);
            }
            $this->productService->delete($id);
            return $this->successResponse(message: 'success', code: 200);
        } catch (\Exception $e) {
            return $this->errorResponse(message: 'Something went wrong!', code: 500);
        }
    }
}
