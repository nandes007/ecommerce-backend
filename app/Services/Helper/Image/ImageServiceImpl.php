<?php

namespace App\Services\Helper\Image;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

class ImageServiceImpl implements ImageService
{
    public function resizeImage($images): array
    {
        $path = resource_path('products/product_images_process/');
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

    public function uploadImage($images): array
    {
        $path = resource_path('products/product_images_process/');
        $imageUploaded = [];
        foreach ($images as $image)
        {
            try {
                Storage::disk('public')->put(
                    'images/products/' . $image,
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
            $imageUploadedUrl = 'images/products/' . $image;
            array_push($imageUploaded, $imageUploadedUrl);
        }

        return $imageUploaded;
    }
}
