<?php

namespace Hackley2\LaravelDockerPackage;

use Illuminate\Support\ServiceProvider;

class DockerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/dist/' => base_path(),
        ], 'docker');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
