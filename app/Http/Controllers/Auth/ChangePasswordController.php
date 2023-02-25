<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ChangePasswordRequest;
use App\Models\User;
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
            return $this->errorResponse(code: 404, message: 'Sorry, user not found!');
        }

        if ($user && Hash::check($oldPassword, $userLoggin->password)) {
            $user->password = Hash::make($newPassword);
            $user->save();
            return $this->successResponse(code: 200, message: 'Your password has been changed successfully.');
        }
    }
}
