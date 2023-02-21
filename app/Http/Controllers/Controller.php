<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function output($status = true, $message = null, $data = null, $code = 200)
    {
        return response()->json(
            [
                'status' => $status,
                'message' => $message,
                'data' => $data,
            ], $code
        );
    }

    public function successResponse($message = null, $data = null, $code = 200)
    {
        return response()->json([
            'code' => $code,
            'message' => $message,
            'data' => $data
        ], $code);
    }

    public function errorResponse($message = null, $code = 500)
    {
        return response()->json([
            'code' => $code,
            'message' => $message
        ], $code);
    }
}
