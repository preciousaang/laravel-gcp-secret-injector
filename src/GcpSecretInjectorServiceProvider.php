<?php

namespace Agz\LaravelGcpSecretInjector;

use Illuminate\Contracts\Foundation\Application;
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
        $this->app->singleton(GcpSecretInjector::class, function (Application $app) {
            return new GcpSecretInjector([
                'project_id' => config('secret-injector.project_id')
            ]);
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
        if (function_exists('config_path')) {
            $this->publishes([
                __DIR__ . '/config/secret-injector.php' => config_path('secret-injector.php')
            ]);
        }
    }
}
