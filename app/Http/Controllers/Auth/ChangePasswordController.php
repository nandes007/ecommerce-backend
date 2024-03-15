<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ChangePasswordRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{
    public function __invoke(ChangePasswordRequest $request)
    {
        $oldPassword = $request->old_password;
        $newPassword = $request->new_password;
        $userLoggin = $request->user();

        $user = User::where('email', $userLoggin->email)->first();

        if (empty($user)) {
            return $this->errorResponse(code: JsonResponse::HTTP_BAD_REQUEST, message: 'User has no longer exist');
        }

        if (!Hash::check($oldPassword, $userLoggin->password)) {
            return $this->errorResponse(code: JsonResponse::HTTP_BAD_REQUEST, message: 'Credential missmatch');
        }

        $user->password = Hash::make($newPassword);
        $user->save();
        return $this->successResponse(code: JsonResponse::HTTP_OK, message: 'Your password has been changed successfully.');
    }
}
