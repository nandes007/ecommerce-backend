<?php

namespace App\Http\Controllers\Auth;

use App\Events\RegisteredUser;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use League\CommonMark\Extension\CommonMark\Node\Inline\Code;

class RegisterController extends Controller
{
    public function send(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'email'],
            'phone_number' => ['required'],
            'password' => ['required', 'confirmed']
        ]);

        $code = rand(100000, 999999);
        $name = $request->input('name');
        $email = $request->input('email');
        $phone_number = $request->input('phone_number');
        $password = $request->input('password');

        $user = User::where('email', $email)->first();

        if (!$user) {
            $user = new User();
            $user->name = $name;
            $user->email = $email;
            $user->phone_number = $phone_number;
            $user->password = Hash::make($password);
            $user->code = $code;
        } else {
            $user->name = $name;
            $user->code = $code;
            $user->phone_number = $phone_number;
            $user->password = Hash::make($password);
        }

        $user->save();
        RegisteredUser::dispatch($user);

        if ($user != null) {
            return $this->output(status: 'success', data: $user->email, code: 201);
        }

        return $this->output(status: 'failed', message: 'Oops something went wrong', code: 400);
    }

    public function verify(Request $request)
    {
        $email = $request->input('email');
        $code = $request->input('code');

        $user = User::where('email', $email)->first();
        if ($user) {
            if ($user->email == $email && $user->code == $code) {
                $user->is_verified = true;
                $user->save();
                return $this->output(status: 'success', message: 'Your account has been verified successfully.', code: 201);
            } else {
                return $this->output(status: 'failed', message: 'Your verification code is invalid.', code: 400);
            }
        }

        return $this->output(status: 'failed', message: 'Your user is not found.', code: 404);
    }
}
