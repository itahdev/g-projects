<?php

namespace App\Providers;

use App\Contracts\Services\AuthService;
use App\Services\AuthServiceImpl;
use Illuminate\Support\ServiceProvider;

class ContractServiceProvider extends ServiceProvider
{
    /**
     * @var string[]
     */
    public array $bindings = [
        AuthService::class => AuthServiceImpl::class,
    ];
}
