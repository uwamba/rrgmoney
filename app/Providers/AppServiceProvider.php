<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

use App\Interfaces\UserRepository;
use App\Repositories\StockAccountRepository;
use App\Services\StockAccountService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //$this->app->singleton('app\Services\StockAccountService', function () {
           // return new \app\Services\StockAccountService();
        //});
       // $this->app->singleton('app\Interfaces\StockAccountInterface', function () {
          //  return new \app\Interfaces\StockAccountInterface();
       // });

        $this->app->bind(StockAccountInterface::class, StockAccountRepository::class);
        $this->app->bind(StockAccountService::class, function ($app) {
            return new StockAccountService($app->make(StockAccountInterface::class));
        });


    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
    }
}
