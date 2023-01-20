<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Admin\Category\CategoryService;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    private $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        try {
            $categories = $this->categoryService->getAllCategory();
            return $this->successResponse(message: 'success', data: $categories, code: 200);
        } catch (\Exception $e) {
            return $this->errorResponse(message: 'Something went wrong', code: 500);
        }
    }

    public function search(Request $request)
    {
        try {
            $categories = $this->categoryService->search($request);
            return $this->successResponse(message: 'success', data: $categories, code: 200);
        } catch (\Exception $e) {
            return $this->errorResponse(message: 'Something went wrong', code: 500);
        }
    }

    public function store(Request $request)
    {
        $request->merge(['slug' => Str::slug($request->name)]);
        try {
            $category = $this->categoryService->storeCategory($request->only(['name', 'parent_id', 'slug']));
            return $this->successResponse(message: 'success', data: $category, code: 201);
        } catch (\Exception $e) {
            return $this->errorResponse(message: 'Something went wrong' . $e, code: 500);
        }
    }

    public function show($id)
    {
        try {
            $category = $this->categoryService->showCategory($id);
            if (empty($category)) {
                return $this->errorResponse(message: 'Category not found!', code: 404);
            }

            return $this->successResponse(message: 'success', data: $category, code: 200);
        } catch (\Exception $e) {
            return $this->errorResponse(message: 'Something went wrong', code: 500);
        }
    }

    public function update(Request $request, $id)
    {
        $category = $this->categoryService->showCategory($id);
        if (empty($category)) {
            return $this->errorResponse(message: 'Category not found!', code: 404);
        }
        try {
            $category = $this->categoryService->updateCategory($request, $id);

            return $this->successResponse(message: 'success', data: $category, code: 200);
        } catch (\Exception $e) {
            return $this->errorResponse(message: 'Something went wrong', code: 500);
        }
    }

    public function delete($id)
    {
        $category = $this->categoryService->showCategory($id);
        if (empty($category)) {
            return $this->errorResponse(message: 'Category not found!', code: 404);
        }

        try {
            $this->categoryService->deleteCategory($id);
            return $this->successResponse(message: 'success', code: 200);
        } catch (\Exception $e) {
            return $this->errorResponse(message: 'Something went wrong!', code: 500);
        }
    }
}
