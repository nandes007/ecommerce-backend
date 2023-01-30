<?php

namespace App\Services\Admin\Product;

interface ProductService
{
 public function getAllProduct();

 public function search($request);

 public function storeProduct($request);

 public function showProduct($id);

 public function updateProduct($request, $id);

 public function deleteProduct($id);
}