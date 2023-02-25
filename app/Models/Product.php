<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'sku',
        'barcode',
        'product_name',
        'slug',
        'unit',
        'fraction',
        'status',
        'avgcost',
        'lastcost',
        'unitprice',
        'price_old',
        'price',
        'weight',
        'tax',
        'description'
    ];

    public function productImages()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }
}
