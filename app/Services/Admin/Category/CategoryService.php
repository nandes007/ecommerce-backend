<?php

namespace App\Services\Admin\Category;

interface CategoryService
{
    public function getAllCategory();

    public function search($request);

    public function storeCategory($request);

    public function showCategory($id);

    public function updateCategory($request, $id);

    public function deleteCategory($id);
}
