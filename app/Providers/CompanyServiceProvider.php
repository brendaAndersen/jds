<?php

namespace App\Providers;
use App\Services\CompanyService;
use App\Repositories\CompanyRepository;

use Illuminate\Support\ServiceProvider;

class CompanyServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(CompanyRepository::class, function ($app) {
            return new CompanyRepository();
        });

        $this->app->singleton(CompanyService::class, function ($app) {
            return new CompanyService($app->make(CompanyRepository::class));
        });
    }
}
