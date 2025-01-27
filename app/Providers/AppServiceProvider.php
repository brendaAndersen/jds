<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\CompanyService;
use App\Repositories\CompanyRepository;

class AppServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->singleton(CompanyService::class, function ($app) {
            return new CompanyService();
        });
    }
    

    public function boot(): void
    {
        //
    }
}
