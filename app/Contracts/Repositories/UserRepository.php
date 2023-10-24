<?php

namespace App\Contracts\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

interface UserRepository
{
    /**
     * @param string $email
     * @return User|Builder|null
     */
    public function findByEmail(string $email): User|Builder|null;
}
