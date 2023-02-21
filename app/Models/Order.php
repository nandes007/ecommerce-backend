<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'id',
        'user_id',
        'status',
        'order_date',
        'payment_due',
        'payment_status',
        'total_gross',
        'tax_amount',
        'tax_percent',
        'discount_amount',
        'discount_percent',
        'shipping_cost',
        'grand_total',
        'note',
        'customer_fullname',
        'customer_address',
        'customer_phone',
        'customer_email',
        'customer_city_id',
        'customer_province_id',
        'customer_postalcode',
        'shipping_courier',
        'shipping_service_name',
        'approved_by',
        'approved_at',
        'cancelled_by',
        'cancelled_at',
        'cancellation_note'
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
