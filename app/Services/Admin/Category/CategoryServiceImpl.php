<?php

namespace App\Services\Admin\Category;

use App\Models\Category;
use Illuminate\Support\Str;

class CategoryServiceImpl implements CategoryService
{
    protected $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function getAllCategory()
    {
        $categories = $this->category->paginate(15);

        return $categories;
    }

    public function search($request)
    {
        $keywords = $request->q;
        $categories = $this->category->select('id', 'name')
            ->orderBy('name', 'ASC')
            ->where('name', 'like', '%'.$keywords.'%')
            ->get();

        return $categories;
    }

    public function storeCategory($request)
    {
        $category = $this->category->create($request);

        return $category;
    }

    public function showCategory($id)
    {
        $category = $this->category->find($id);

        return $category;
    }

    public function updateCategory($request, $id)
    {
        $category = $this->category
            ->where('id', $id)
            ->update($request);

        return $category;
    }

    public function deleteCategory($id)
    {
        return $this->category->find($id)->delete();
    }
}
