<?php

namespace App\Providers;

use App\Services\Interfaces\FinanceServiceInterface;
use App\Services\YahooFinanceService;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(FinanceServiceInterface::class, function (Application $app) {
            return new YahooFinanceService();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
