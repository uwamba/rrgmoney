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
        $models = array(
            'CustomModel'
        );

        foreach ($models as $idx => $model) {
            $this->app->bind("App\Interfaces\{$model}Interface", "App\Repositories\{$model}Repository");
        }
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
