<?php

namespace App\Models;

use App\Services\Helper\Image\ImageServiceImpl;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Banner extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'title',
        'url',
        'status',
        'image_path'
    ];

    protected $appends = [
        'image_path_url'
    ];

    public function getImagePathUrlAttribute()
    {
        return ImageServiceImpl::imageUrl() . '/' . $this->image_path;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
