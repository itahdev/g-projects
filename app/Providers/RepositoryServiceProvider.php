<?php

namespace App\Providers;

use App\Contracts\Repositories\UserRepository;
use App\Repositories\UserRepositoryImpl;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * @var string[]
     */
    public array $bindings = [
        UserRepository::class => UserRepositoryImpl::class,
    ];
}
