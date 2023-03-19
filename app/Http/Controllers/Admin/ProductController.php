<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductRequest;
use App\Services\Admin\Product\ProductService;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;

class ProductController extends Controller
{
    public function __construct(protected ProductService $productService)
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
            'price_old' => $request->price,
            'product_images' => $request->images
        ]);

        $images = $request->file('images');

        $urls = [];

        foreach ($images as $image) {
            $resizedImage = Image::make($image)->resize(500, null, function ($constraint) {
                $constraint->aspectRatio();
            });

            $filename = time() . '_' . $image->getClientOriginalName();
            $resizedImage->save(public_path('images/' . $filename));

            $urls[] = asset('images/' . $filename);
        }

        return response()->json($urls);
//        return response()->json($request->images);
//        return response()->json($request->header());

//        try {
//            $product = $this->productService->save($request->all());
//            return $this->successResponse(message: 'success', data: $product, code: 201);
//        } catch (\Exception $e) {
//            return $this->errorResponse(message: 'Something went wrong' . $e, code: 500);
//        }
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
