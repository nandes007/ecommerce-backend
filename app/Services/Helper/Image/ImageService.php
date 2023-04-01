<?php

namespace App\Services\Helper\Image;

interface ImageService
{
    public function resizeImage($images);

    public function uploadImage($images);
}
