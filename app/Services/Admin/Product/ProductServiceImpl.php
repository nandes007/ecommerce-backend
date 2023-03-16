<?php

namespace App\Services\Admin\Product;

use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductServiceImpl implements ProductService
{
 public function __construct(protected Product $product)
 {}

 public function getAll()
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

 public function save($request)
 {
     $request["category_ids"] = 1;
     $product = DB::transaction(function() use ($request) {
        $product = Product::create($request);

        if (!empty($request["category_ids"])) {
            $product->categories()->attach(1); // still hardcode, you can attach category_ids then
        }

        return $product;
     }, 5);

     return $product;
 }

 public function find($id)
 {
     return $this->product->find($id);
 }

 public function update($request, $id)
 {
     return $this->product
        ->where('id', $id)
        ->update([
            "sku" => $request["sku"],
            "barcode" => $request["barcode"],
            "product_name" => $request["product_name"],
            "slug" => Str::slug($request["product_name"]),
            "unit" => $request["unit"],
            "fraction" => $request["fraction"],
            "status" => $request["status"],
            "avgcost" => $request["avgcost"],
            "lastcost" => $request["lastcost"],
            "unitprice" => $request["unitprice"],
            "price_old" => $request["price_old"],
            "price" => $request["price"],
            "weight" => $request["weight"],
            "tax" => $request["tax"],
            "description" => $request["description"]
        ]);
 }

 public function delete($id)
 {
    return $this->product->find($id)->delete();
 }
}
