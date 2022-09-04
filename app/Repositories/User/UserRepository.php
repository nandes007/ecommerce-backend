<?php

namespace App\Repositories\User;

interface UserRepository
{
    public function updateProfile($id, $data);
}