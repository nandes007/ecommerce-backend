<?php

namespace App\Repositories\User;

use App\Models\User;
use Illuminate\Http\Request;

interface UserRepository
{
    public function store(Request $request):?User;

    public function find(int $id):?User;

    public function findByEmail(string $emil):?User;

    public function update(Request $request, int $id):?User;
}