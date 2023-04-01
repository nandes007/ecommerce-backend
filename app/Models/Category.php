<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'parent_id'
    ];

    protected $appends = [
        'label',
        'value'
    ];

    public function getLabelAttribute()
    {
        return $this->name;
    }

    public function getValueAttribute()
    {
        return $this->id;
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_categories');
    }
}
