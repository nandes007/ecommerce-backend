<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Jobs\EmailVerifySenderJob;
use App\Models\User;
use App\Services\User\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function __construct(protected UserService $userService)
    {
        //
    }
    
    public function register(RegisterRequest $request)
    {
        $user = User::where('email', $request->email)->first();
        if ($user) {
            return response()->json([
                'message' => 'User has been registered'
            ], JsonResponse::HTTP_BAD_REQUEST);
        }

        $user = $this->userService->storeUser($request);

        return response()->json([
            'message' => 'Successfully registered user'
        ], JsonResponse::HTTP_OK);
    }

    public function send(RegisterRequest $request)
    {
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
        EmailVerifySenderJob::dispatch($user);
        return $this->successResponse(message: 'Your user has been registered successfuly', data: $user, code: JsonResponse::HTTP_OK);
    }

    public function verify(Request $request)
    {
        $email = $request->input('email');
        $code = $request->input('code');

        $user = User::where('email', $email)->first();

        if (empty($user)) {
            return $this->errorResponse(message: 'User has no longer exist!', code: JsonResponse::HTTP_BAD_REQUEST);
        }

        if ($user->email != $email || $user->code != $code) {
            return $this->errorResponse(message: 'Invalid verify coed', code: JsonResponse::HTTP_BAD_REQUEST);
        }

        $user->is_verified = true;
        $user->save();
        return $this->successResponse(message: 'Your account has been verified successfully.', code: JsonResponse::HTTP_OK);
    }
}
