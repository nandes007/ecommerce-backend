<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\User\UserService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function updateProfile(Request $request)
    {
        $userId = $request->user()->id;
        $data = $request->all();

        try {
            $result = $this->userService->updateProfile($userId, $data);
            return $this->successResponse(data: $result, message: "Successfully updated profile", code: JsonResponse::HTTP_OK);
        } catch (Exception $e) {
            return $this->errorResponse(message: "Sorry, something went wrong", code: JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function check(Request $request)
    {
        $authHeader = $request->header('Authorization');
        $keyAuth = substr($authHeader, 7);
        [$id, $token] = explode('|', $keyAuth, 2);
        $accessToken = PersonalAccessToken::find($id);

        if (empty($accessToken)) {
            return $this->errorResponse(message: 'Token not found!', code: 404);
        }

        if (hash_equals($accessToken->token, hash('sha256', $token))) {
            return $this->successResponse(message: 'Token is match.', code: 200, data: $accessToken);
        } else {
            return $this->errorResponse(message: 'Token is miss match', code: 401);
        }
    }

    public function profile(Request $request)
    {
        $data = [
            'name' => $request->user()->name,
            'email' => $request->user()->email,
            'phone_number' => $request->user()->phone_number,
            'gender' => $request->user()->gender,
            'birth_of_date' => $request->user()->birth_of_date,
            'type' => $request->user()->type,
            'province_id' => $request->user()->province_id,
            'city_id' => $request->user()->city_id,
            'address' => $request->user()->address,
            'postalcode' => $request->user()->postalcode
        ];

        return $this->successResponse(message: 'success', data: $data, code: 200);
    }

    public function logout(Request $request)
    {
        $user = $request->user()->currentAccessToken()->delete();

        if (empty($user)) {
            return $this->errorResponse(message: 'User not found!', code: 404);
        }

        return $this->successResponse(message: 'You are logout', code: 200);
    }
}
