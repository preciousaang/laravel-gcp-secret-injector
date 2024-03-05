<?php

namespace Agz\LaravelGcpSecretInjector;

use Illuminate\Support\ServiceProvider;

class GcpSecretInjectorServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        if (function_exists('config_path')) {
            $this->publishes([
                __DIR__ . '/config/secret-injector.php' => config_path('secret-injector.php')
            ]);
        }
    }
}