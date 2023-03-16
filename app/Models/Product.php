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

    /**
     * Product image relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function productImages()
    {
        return $this->hasMany(ProductImage::class);
    }

    /**
     * Product category relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_categories');
    }

    /**
     * Cart item relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }
}
