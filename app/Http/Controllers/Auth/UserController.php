<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class UserController extends Controller
{
    public function check(Request $request)
    {
        $authHeader = $request->header('Authorization');
        $keyAuth = substr($authHeader, 7);
        [$id, $token] = explode('|', $keyAuth, 2);
        $accessToken = PersonalAccessToken::find($id);
        
        if ($accessToken) {
            if (hash_equals($accessToken->token, hash('sha256', $token))) {
                return $this->output(status: 'success', message: 'Token is match.', code: 200);
            } else {
                return $this->output(status: 'failed', message: 'Token is miss match', code: 401);
            }
        }
        return $this->output(status: 'failed', message: 'Token is not found', code: 401);
    }

    public function profile(Request $request)
    {
        $data = [
            'name' => $request->user()->name,
            'email' => $request->user()->email,
            'phone_number' => $request->user()->phone_number,
        ];

        return $this->output(status: 'success', data: $data, code: 200);
    }

    public function logout(Request $request)
    {
        $user = $request->user()->currentAccessToken()->delete();

        if ($user) {
            return $this->output(status: 'success', message: 'You are logout', code: 200);
        }

        return $this->output(status: 'failed', message: 'Logout is failed', code: 400);
    }
}
