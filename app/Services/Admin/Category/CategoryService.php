<?php

namespace App\Services\Admin\Category;

interface CategoryService
{
    public function getAll();

    public function search($request);

    public function save($request);

    public function find($id);

    public function update($request, $id);

    public function delete($id);
}
