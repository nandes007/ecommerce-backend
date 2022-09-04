<?php

namespace App\Repositories\User;

use App\Models\User;

class UserRepositoryImpl implements UserRepository
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function updateProfile($id, $data): User
    {
        $user = $this->user->find($id);
        
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->phone_number = $data['phone_number'];
        $user->birth_of_date = $data['birth_of_date'];
        $user->gender = $data['gender'];
        $user->province_id = $data['province_id'];
        $user->city_id = $data['city_id'];
        $user->address = $data['address'];
        $user->postalcode = $data['postalcode'];

        $user->save();

        return $user;
    }
}