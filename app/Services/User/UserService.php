<?php

namespace App\Services\User;

interface UserService
{
    public function updateProfile($id, $data);
}