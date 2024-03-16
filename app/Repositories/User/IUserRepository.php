<?php

namespace App\Repositories\User;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class IUserRepository implements UserRepository
{
    public function store(Request $request):?User
    {
        return User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'password' => Hash::make($request->password) 
        ]);
    }

    public function find(int $id):?User
    {
        return User::find($id);
    }

    public function findByEmail(string $emil): ?User
    {
        return User::where('email', $emil)->first();
    }

    public function update(Request $request, int $id):?User
    {
        $user = $this->find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;
        $user->birth_of_date = $request->birth_of_date;
        $user->gender = $request->gender;
        $user->province_id = $request->province_id;
        $user->city_id = $request->city_id;
        $user->address = $request->address;
        $user->postalcode = $request->postalcode;

        return $user;
    }
}