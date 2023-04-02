<?php

namespace App\Services\Helper\Image;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

class ImageServiceImpl implements ImageService
{
    protected int $width;
    protected int $height;

    public static function imageUrl()
    {
        return env('APP_URL', 'localhost:8000') . 'storage';
    }

    public function resizeImage($image, $storagePath)
    {
        switch ($storagePath) {
            case 'products':
                $this->width = 500;
                $this->height = 500;
                break;
            case 'banners':
                $this->width = 1240;
                $this->height = 445;
                break;
        }

        $path = resource_path('image_process' . '/' . $storagePath  . '_images_process/');
        if (!File::exists($path)) {
            File::makeDirectory($path, 0777, true, true);
        }

        $extension = $image->getClientOriginalExtension();
        $originalNameFormatted = preg_replace('/\s+/', '', $image->getClientOriginalName());
        $filename = time() . '_' . $originalNameFormatted;
        if (in_array($extension, ['jpg', 'jpeg', 'png'])) {
            $imageResized = Image::make($image);
            $imageResized->resize($this->width, $this->height);
            $imageResized->save($path . $filename);
        }
        return $filename;
    }

    public function uploadImage($image, $storagePath)
    {
        $path = resource_path('image_process' . '/' . $storagePath  . '_images_process/');
        if (!File::exists($path)) {
            File::makeDirectory($path, 0777, true, true);
        }
        try {
            Storage::disk('public')->put(
                'images/' . $storagePath . '/' . $image,
                file_get_contents($path . $image)
            );
        } catch (\Exception $e) {}

        try {
            unlink($path . $image);
        } catch (\Exception $e) {}

        return 'images/' . $storagePath . '/' . $image;
    }

    public function resizeMultipleImages($images, $storagePath): array
    {
        switch ($storagePath) {
            case 'products':
                $this->width = 500;
                $this->height = 500;
                break;
            case 'banners':
                $this->width = 1240;
                $this->height = 445;
                break;
        }

        $path = resource_path('image_process' . '/' . $storagePath  . '_images_process/');
        if (!File::exists($path)) {
            File::makeDirectory($path, 0777, true, true);
        }
        $imageResource = [];
        foreach ($images as $image)
        {
            $extension = $image->getClientOriginalExtension();
            $originalNameFormatted = preg_replace('/\s+/', '', $image->getClientOriginalName());
            $filename = time() . '_' . $originalNameFormatted;
            if (in_array($extension, ['jpg', 'jpeg', 'png'])) {
                $imageResized = Image::make($image);
                $imageWidth = $imageResized->width();
                if ($imageWidth > 500) {
                    $imageResized->resize(500, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                }
                $imageResized->save($path . $filename);
                array_push($imageResource, $filename);
            }
        }
        return $imageResource;
    }

    public function uploadMultipleImages($images, $storagePath): array
    {
        $path = resource_path('image_process' . '/' . $storagePath  . '_images_process/');
        $imageUploaded = [];
        foreach ($images as $image)
        {
            try {
                Storage::disk('public')->put(
                    'images/' . $storagePath . '/' . $image,
                    file_get_contents($path . $image)
                );
            } catch (\Exception $e) {
                // catch if store file failed
                continue;
            }

            try {
                unlink($path . $image);
            } catch (\Exception $e) {
                continue;
            }
            $imageUploadedUrl = 'images/' . $storagePath . '/' . $image;
            array_push($imageUploaded, $imageUploadedUrl);
        }

        return $imageUploaded;
    }
}
