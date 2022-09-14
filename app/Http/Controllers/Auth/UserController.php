<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\User\UserService;
use Exception;
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
            $statusCode = 200;
            $message = 'success';
            $status = true;
        } catch (Exception $e) {
            $result = [];
            $statusCode = 500;
            $message = $e->getMessage();
            $status = true;
        }

        return $this->output(status: $status, data: $result, message: $message, code:$statusCode);
    }

    public function check(Request $request)
    {
        $authHeader = $request->header('Authorization');
        $keyAuth = substr($authHeader, 7);
        [$id, $token] = explode('|', $keyAuth, 2);
        $accessToken = PersonalAccessToken::find($id);
        
        if ($accessToken) {
            if (hash_equals($accessToken->token, hash('sha256', $token))) {
                return $this->output(status: true, message: 'Token is match.', code: 200);
            } else {
                return $this->output(status: false, message: 'Token is miss match', code: 401);
            }
        }
        return $this->output(status: false, message: 'Token is not found', code: 401);
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

        return $this->output(status: true, data: $data, code: 200);
    }

    public function logout(Request $request)
    {
        $user = $request->user()->currentAccessToken()->delete();

        if ($user) {
            return $this->output(status: true, message: 'You are logout', code: 200);
        }

        return $this->output(status: false, message: 'Logout is failed', code: 400);
    }
}
