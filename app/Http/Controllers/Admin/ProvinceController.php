<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProvinceRequest;
use App\Services\Admin\Province\ProvinceService;

class ProvinceController extends Controller
{
    protected ProvinceService $provinceService;

    public function __construct(ProvinceService $provinceService)
    {
        $this->provinceService = $provinceService;
    }

    public function index()
    {
        try {
            $provinces = $this->provinceService->getAll();
            return $this->successResponse(message: 'success', data: $provinces, code: 200);
        } catch (\Exception $e) {
            return $this->errorResponse(message: 'Something went wrong', code: 500);
        }
    }

    public function store(ProvinceRequest $request)
    {
        try {
            $provinces = $this->provinceService->save($request->only(['name']));
            return $this->successResponse(message: 'success', data: $provinces, code: 201);
        } catch (\Exception $e) {
            return $this->errorResponse(message: 'Something went wrong', code: 500);
        }
    }

    public function show($id)
    {
        try {
            $province = $this->provinceService->find($id);
            if (empty($province)) {
                return $this->errorResponse(message: 'Province not found!', code: 404);
            }

            return $this->successResponse(message: 'success', data: $province, code: 200);
        } catch (\Exception $e) {
            return $this->errorResponse(message: 'Something went wrong', code: 500);
        }
    }

    public function update(ProvinceRequest $request, $id)
    {
        try {
            $province = $this->provinceService->find($id);
            if (empty($province)) {
                return $this->errorResponse(message: 'Province not found!', code: 404);
            }

            $this->provinceService->update($request, $id);
            return $this->successResponse(message: 'success', code: 200);
        } catch (\Exception $e) {
            return $this->errorResponse(message: 'Something went wrong', code: 500);
        }
    }

    public function destroy($id)
    {
        try {
            $province = $this->provinceService->find($id);
            if (empty($province)) {
                return $this->errorResponse(message: 'Province not found!', code: 404);
            }
            $this->provinceService->delete($id);
            return $this->successResponse(message: 'success', code: 200);
        } catch (\Exception $e) {
            return $this->errorResponse(message: 'Something went wrong', code: 500);
        }
    }
}
