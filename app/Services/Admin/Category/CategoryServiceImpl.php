<?php

namespace App\Services\Admin\Category;

use App\Models\Category;
use Illuminate\Support\Str;

class CategoryServiceImpl implements CategoryService
{
    protected Category $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function getAll()
    {
        return $this->category->paginate(15);
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

    public function save($request)
    {
        return $this->category->create($request);
    }

    public function find($id)
    {
        return $this->category->find($id);
    }

    public function update($request, $id)
    {
        return $this->category
            ->where('id', $id)
            ->update([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'parent_id' => $request->parent_id
            ]);
    }

    public function delete($id)
    {
        return $this->category->find($id)->delete();
    }
}
