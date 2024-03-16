<?php

namespace App\Services\User;

use App\Models\User;
use App\Repositories\User\UserRepository;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;

class UserServiceImpl implements UserService
{
    protected UserRepository $userRepository;
    protected $user;

    public function __construct(User $user, UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->user = $user;
    }

    public function storeUser(Request $request):?User
    {
        return $this->userRepository->store($request);
    }

    public function findUserById(int $id): ?User
    {
        return $this->userRepository->find($id);
    }

    public function findUserByEmail(string $email): ?User
    {
        return $this->userRepository->findByEmail($email);
    }

    public function updateUser(Request $request, int $id): ?User
    {
        return $this->userRepository->update($request, $id);
    }

    public function updateProfile($id, $data) : User
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
