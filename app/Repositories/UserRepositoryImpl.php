<?php

namespace App\Repositories;

use App\Contracts\Repositories\UserRepository;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class UserRepositoryImpl implements UserRepository
{
    /**
     * @param string $email
     * @return User|Builder|null
     */
    public function findByEmail(string $email): User|Builder|null
    {

    }
}
