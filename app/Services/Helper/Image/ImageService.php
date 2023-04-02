<?php

namespace App\Services\Helper\Image;

interface ImageService
{
    public function resizeImage($image, $storagePath);

    public function uploadImage($image, $storagePath);

    public function resizeMultipleImages($images, $storagePath);

    public function uploadMultipleImages($images, $storagePath);
}
