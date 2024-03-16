<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Services\User\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function __construct(protected UserService $userService)
    {
        
    }
    
    public function __invoke(LoginRequest $request)
    {
        $user = $this->userService->findUserByEmail($request->email);
        if (empty($user) || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'The provided credentials are incorrect.'
            ], JsonResponse::HTTP_BAD_REQUEST);
        }

        $token = $user->createToken($request->device_name);
        return response()->json([
            'token' => $token->plainTextToken,
            'message' => 'Successfully Login'
        ], JsonResponse::HTTP_OK);
    }
}
