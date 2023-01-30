<?php

namespace App\Services\Admin\Product;

use App\Models\Product;

class ProductServiceImpl implements ProductService
{
 public function __construct(protected Product $product)
 {}

 public function getAllProduct()
 {
  return $this->product->paginate(10);
 }

 public function search($request)
 {
  return $this->product
            ->select('id', 'sku', 'barcode', 'product_name', 'fraction', 'unit', 'unitprice', 'price')
            ->orderBy('name', 'ASC')
            ->where('name', 'like', '%'.$request->q.'%')
            ->get();
 }

 public function storeProduct($request)
 {
  return $this->product->create($request);
 }

 public function showProduct($id)
 {
  return $this->product->find($id);
 }

 public function updateProduct($request, $id)
 {

 }

 public function deleteProduct($id)
 {

 }
}
