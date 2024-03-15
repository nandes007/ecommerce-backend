<?php

namespace App\Http\Controllers\Auth;

use App\Events\RegisteredUser;
use App\Http\Controllers\Controller;
use App\Jobs\EmailVerifySenderJob;
use App\Models\User;
use Illuminate\Http\JsonResponse;
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
            return $this->errorResponse(message: 'User has been no longer exist!', code: JsonResponse::HTTP_BAD_REQUEST);
        }

        $user->code = $code;
        $user->save();
        EmailVerifySenderJob::dispatch($user);
        return $this->successResponse(message: 'Verification code has been sent.', data: $user, code: JsonResponse::HTTP_OK);
    }
}
