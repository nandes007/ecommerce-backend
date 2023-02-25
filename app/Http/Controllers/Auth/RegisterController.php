<?php

namespace App\Http\Controllers\Auth;

use App\Events\RegisteredUser;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use League\CommonMark\Extension\CommonMark\Node\Inline\Code;

class RegisterController extends Controller
{
    public function send(RegisterRequest $request)
    {
        $request->validated();

        $code = rand(100000, 999999);
        $name = $request->name;
        $email = $request->email;
        $phone_number = $request->phone_number;
        $password = $request->password;

        $user = User::where('email', $email)->first();

        if (empty($user)) {
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

        if (empty($user)) {
            return $this->errorResponse(message: 'Oops something went wrong!', code: 500);
        }

        return $this->successResponse(message: 'Your user has been registered successfuly', data: $user, code: 200);
    }

    public function verify(Request $request)
    {
        $email = $request->input('email');
        $code = $request->input('code');

        $user = User::where('email', $email)->first();

        if (empty($user)) {
            return $this->errorResponse(message: 'User not found!', code: 404);
        }

        if ($user->email == $email && $user->code == $code) {
            $user->is_verified = true;
            $user->save();
            return $this->successResponse(message: 'Your account has been verified successfully.', code: 200);
        }
    }
}
