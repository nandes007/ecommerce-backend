<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function __invoke(LoginRequest $request)
    {
        $email = $request->email;
        $password = $request->password;
        $device_name = $request->device_name;

        $user = User::where('email', $email)->first();

        if (empty($user) || !Hash::check($password, $user->password)) {
            throw ValidationException::withMessages([
                'message' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken($device_name);

        return $this->successResponse(message: 'Login success', data: $token->plainTextToken, code: JsonResponse::HTTP_OK);
    }
}
