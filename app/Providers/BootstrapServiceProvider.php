<?php

namespace App\Providers;

use App\Contracts\Services\StorageService;
use App\Services\StorageServiceImpl;
use Illuminate\Support\ServiceProvider;

class BootstrapServiceProvider extends ServiceProvider
{
    /**
     * @var string[]
     */
    public array $bindings = [
        StorageService::class => StorageServiceImpl::class,
    ];
}
