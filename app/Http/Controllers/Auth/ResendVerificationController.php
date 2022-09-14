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

        if (!$user) {
            return response()->json([
                'status' => 'failed',
                'message' => 'user not found'
            ], 404);
        }

        $user->code = $code;
        $user->save();
        RegisteredUser::dispatch($user);
        return $this->output(status: true, message: 'Verification code has been sent.', code: 200);
    }
}
