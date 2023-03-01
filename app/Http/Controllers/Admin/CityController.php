<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CityRequest;
use App\Services\Admin\City\CityService;
use Illuminate\Http\Request;

class CityController extends Controller
{
    protected CityService $cityService;

    public function __construct(CityService $cityService)
    {
        $this->cityService = $cityService;
    }

    public function index()
    {
        try {
            $cities = $this->cityService->getAll();
            return $this->successResponse(message: 'success', data: $cities, code: 200);
        } catch (\Exception $e) {
            return $this->errorResponse(message: 'Something went wrong', code: 500);
        }
    }

    public function store(CityRequest $request)
    {
        try {
            $cities = $this->cityService->save($request->only([
                'province_id',
                'name'
            ]));
            return $this->successResponse(message: 'success', data: $cities, code: 201);
        } catch (\Exception $e) {
            return $this->errorResponse(message: 'Something went wrong', code: 500);
        }
    }

    public function show($id)
    {
        try {
            $city = $this->cityService->find($id);
            if (empty($city)) {
                return $this->errorResponse(message: 'City not found!', code: 404);
            }

            return $this->successResponse(message: 'success', data: $city, code: 200);
        } catch (\Exception $e) {
            return $this->errorResponse(message: 'Something went wrong', code: 500);
        }
    }

    public function update(CityRequest $request, $id)
    {
        try {
            $city = $this->cityService->find($id);
            if (empty($city)) {
                return $this->errorResponse(message: 'City not found!', code: 404);
            }

            $this->cityService->update($request, $id);
            return $this->successResponse(message: 'success', code: 200);
        } catch (\Exception $e) {
            return $this->errorResponse(message: 'Something went wrong', code: 500);
        }
    }

    public function delete($id)
    {
        try {
            $city = $this->cityService->find($id);
            if (empty($city)) {
                return $this->errorResponse(message: 'City not found!', code: 404);
            }
            $this->cityService->delete($id);
            return $this->successResponse(message: 'success', code: 200);
        } catch (\Exception $e) {
            return $this->errorResponse(message: 'Something went wrong!', code: 500);
        }
    }
}
