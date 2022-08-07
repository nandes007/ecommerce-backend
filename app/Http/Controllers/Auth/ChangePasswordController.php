<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'old_password' => ['required'],
            'new_password' => ['required', 'confirmed']
        ]);

        $oldPassword = $request->input('old_password');
        $newPassword = $request->input('new_password');
        $userLoggin = $request->user();

        $user = User::where('email', $userLoggin->email)->first();

        if ($user && Hash::check($oldPassword, $userLoggin->password)) {
            $user->password = Hash::make($newPassword);
            $user->save();
            return $this->output(status: 'success', message: 'Your password has been changed successfully.', code: 201);
        }

        return $this->output(status: 'failed', message: 'The provided credentials are incorrect.', code: 400);
    }
}
