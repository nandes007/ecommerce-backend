<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BannerRequest;
use App\Services\Admin\Banner\BannerService;
use App\Services\Helper\Image\ImageService;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function __construct(protected BannerService $bannerService, protected ImageService $imageService)
    {
    }

    public function index()
    {
        try {
            $banners = $this->bannerService->getAll();
            return $this->successResponse(message: 'success', data: $banners, code: 200);
        } catch (\Exception $e) {
            return $this->errorResponse(message: 'Something went wrong', code: 500);
        }
    }

    public function store(BannerRequest $request)
    {
        $user_id = $request->user()->id;
        $request->merge([
            'user_id' => $user_id
        ]);
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageResized = $this->imageService->resizeImage($image, 'banners');
            $imageUploaded = $this->imageService->uploadImage($imageResized, 'banners');
            $request->merge([
                'image_path' => $imageUploaded
            ]);
        }

        try {
            $banner = $this->bannerService->save($request->all());
            return $this->successResponse(message: 'success', data: $banner, code: 201);
        } catch (\Exception $e) {
            return $this->errorResponse(message: 'Something went wrong' . $e, code: 500);
        }
    }

    public function show($id)
    {
        try {
            $banner = $this->bannerService->find($id);
            if (empty($banner)) {
                return $this->errorResponse(message: 'Banner not found!', code: 404);
            }

            return $this->successResponse(message: 'success', data: $banner, code: 200);
        } catch (\Exception $e) {
            return $this->errorResponse(message: 'Something went wrong', code: 500);
        }
    }

    public function update(BannerRequest $request, $id)
    {
        try {
            $banner = $this->bannerService->find($id);
            if (empty($banner)) {
                return $this->errorResponse(message: 'Banner not found!', code: 404);
            }

            $this->bannerService->update($request->all(), $id);

            return $this->successResponse(message: 'success', code: 200);
        } catch (\Exception $e) {
            return $this->errorResponse(message: 'Something went wrong', code: 500);
        }
    }

    public function destroy($id)
    {
        try {
            $banner = $this->bannerService->find($id);
            if (empty($banner)) {
                return $this->errorResponse(message: 'Banner not found!', code: 404);
            }
            $this->bannerService->delete($id);
        } catch (\Exception $e) {
            return $this->errorResponse(message: 'Something went wrong', code: 500);
        }
    }
}
