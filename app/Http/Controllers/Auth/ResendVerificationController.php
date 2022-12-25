<?php

namespace App\Http\Controllers\Auth;

use App\Events\RegisteredUser;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ResendVerificationController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'email' => ['required']
        ]);

        $code = rand(100000, 999999);
        $email = $request->input('email');

        $user = User::where('email', $email)->first();

        if (empty($user)) {
            return $this->errorResponse(message: 'User not found!', code: 404);
        }

        $user->code = $code;
        $user->save();
        RegisteredUser::dispatch($user);
        return $this->successResponse(message: 'Verification code has been sent.', data: $user, code: 200);
    }
}
