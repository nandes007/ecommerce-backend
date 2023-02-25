<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_id',
        'product_id',
        'quantity',
        'product_name',
        'sku',
        'barcode',
        'slug',
        'tax',
        'tax_percent',
        'tax_amount',
        'discount_percent',
        'discount_amount',
        'price',
        'net_price',
        'total'
    ];

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
