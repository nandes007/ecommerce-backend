<?php

namespace App\Services\User;

use App\Models\User;
use Illuminate\Http\Request;

interface UserService
{
    public function storeUser(Request $request):?User;
    public function findUserById(int $id):?User;
    public function findUserByEmail(string $email):?User;
    public function updateUser(Request $request, int $id):?User;
    public function updateProfile($id, $data);
}