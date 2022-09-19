<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id',
        'product_id',
        'qty',
        'weight',
        'avg_cost',
        'price',
        'tax_amount',
        'tax_percent',
        'discount_amount',
        'discount_percent',
        'gross',
        'sub_total'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
