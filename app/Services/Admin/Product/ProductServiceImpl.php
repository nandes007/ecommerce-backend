<?php

namespace App\Services\Admin\Product;

use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;

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
     if (!empty($request["product_images"])) {
         $productImages = $request["product_images"];
         foreach ($productImages as $productImage) {
             $resizedImage = Image::make($productImage)->resize(500, null, function($constraint) {
                 $constraint->aspecRatio();
             });

             $filename = time() . '_' . $productImage->getClientOriginalName();
             $resizedImage->save(public_path('images/'. $filename));

             $urls[] = asset('images/' . $filename);
         }
     }
//     $product = DB::transaction(function() use ($request) {
//        $product = Product::create($request);
//         $urls= [];
//
//        if (!empty($request["category_ids"])) {
//            $product->categories()->attach($request['category_ids']); // still hardcode, you can attach category_ids then
//        }
//
//        if (!empty($request["product_images"])) {
//            $productImages = $request["product_images"];
//            foreach ($productImages as $productImage) {
//                $resizedImage = Image::make($productImage)->resize(500, null, function($constraint) {
//                    $constraint->aspecRatio();
//                });
//
//                $filename = time() . '_' . $productImage->getClientOriginalName();
//                $resizedImage->save(public_path('images/'. $filename));
//
//                $urls[] = asset('images/' . $filename);
//            }
//        }
//        return $request["product_images"];
//     }, 5);

     return $request["product_images"];
 }

 public function find($id)
 {
     return $this->product->with('categories')->find($id);
 }

 public function update($request, $id)
 {
     $product = DB::transaction(function() use ($request, $id) {
         $product = $this->product->with('categories')->find($id);
         $product->update([
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

             if (!empty($request["category_ids"])) {
                 $product->categories()->sync($request['category_ids']); // still hardcode, you can attach category_ids then
             }

             return $product;
     }, 5);

     return $product;
 }

 public function delete($id)
 {
     $product = DB::transaction(function() use ($id) {
        $product = $this->product
                        ->with('categories')
                        ->find($id);

        $product->categories()->detach();

        return $product->delete();
     });
    return $product;
 }
}
