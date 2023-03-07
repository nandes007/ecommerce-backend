<?php

namespace App\Services\Admin\Product;

interface ProductService
{
 public function getAll();

 public function search($request);

 public function save($request);

 public function find($id);

 public function update($request, $id);

 public function delete($id);
}
