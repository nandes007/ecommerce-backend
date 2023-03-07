<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryRequest;
use App\Services\Admin\Category\CategoryService;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    private CategoryService $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        try {
            $categories = $this->categoryService->getAll();
            return $this->successResponse(message: 'success', data: $categories, code: 200);
        } catch (\Exception $e) {
            return $this->errorResponse(message: 'Something went wrong', code: 500);
        }
    }

    public function search(CategoryRequest $request)
    {
        try {
            $categories = $this->categoryService->search($request);
            return $this->successResponse(message: 'success', data: $categories, code: 200);
        } catch (\Exception $e) {
            return $this->errorResponse(message: 'Something went wrong', code: 500);
        }
    }

    public function store(CategoryRequest $request)
    {
        $request->merge(['slug' => Str::slug($request->name)]);
        try {
            $category = $this->categoryService->save($request->only(['name', 'parent_id', 'slug']));
            return $this->successResponse(message: 'success', data: $category, code: 201);
        } catch (\Exception $e) {
            return $this->errorResponse(message: 'Something went wrong', code: 500);
        }
    }

    public function show($id)
    {
        try {
            $category = $this->categoryService->find($id);
            if (empty($category)) {
                return $this->errorResponse(message: 'Category not found!', code: 404);
            }

            return $this->successResponse(message: 'success', data: $category, code: 200);
        } catch (\Exception $e) {
            return $this->errorResponse(message: 'Something went wrong', code: 500);
        }
    }

    public function update(CategoryRequest $request, $id)
    {
        try {
            $category = $this->categoryService->find($id);
            if (empty($category)) {
                return $this->errorResponse(message: 'Category not found!', code: 404);
            }

            $this->categoryService->update($request->all(), $id);

            return $this->successResponse(message: 'success', code: 200);
        } catch (\Exception $e) {
            return $this->errorResponse(message: 'Something went wrong', code: 500);
        }
    }

    public function destroy($id)
    {
        try {
            $category = $this->categoryService->find($id);
            if (empty($category)) {
                return $this->errorResponse(message: 'Category not found!', code: 404);
            }
            $this->categoryService->delete($id);
            return $this->successResponse(message: 'success', code: 200);
        } catch (\Exception $e) {
            return $this->errorResponse(message: 'Something went wrong!', code: 500);
        }
    }
}
