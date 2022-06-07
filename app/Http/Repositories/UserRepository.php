<?php

namespace App\Http\Repositories;

use App\Models\User;

class UserRepository
{
    public function createUser($data) {
        return User::create($data);
    }

    public function getUser($email){
        return User::query()
            ->where('email', 'like', '%'. $email .'%')
            ->first();
    }
}
