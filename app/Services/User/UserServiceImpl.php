<?php

namespace App\Services\User;

use App\Repositories\User\UserRepository;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class UserServiceImpl implements UserService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function updateProfile($id, $data)
    {
        $validator = Validator::make($data, [
            'name' => ['required'],
            'email' => ['required'],
            'phone_number' => ['required'],
            'birth_of_date' => ['required'],
            'gender' => ['required'],
            'province_id' => ['required'],
            'city_id' => ['required'],
            'address' => ['required'],
            'postalcode' => ['required']
        ]);

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        return $this->userRepository->updateProfile($id, $data);
    }
}