<?php

namespace Agz\LaravelGcpSecretInjector;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Agz\LaravelGcpSecretInjector\Facades\SecretInjector as SecretInjectorFacade;

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

        $this->app->singleton('agz-gcp-secret-injector', function (Application $app) {
            return new GcpSecretInjector([
                'project_id' => config('secret-injector.project_id')
            ]);
        });

        $this->loadSecrets();
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

    /**
     * Load all declared secrets from secret manager into the environment
     * 
     * @return void
     */

    public function loadSecrets()
    {
        $secrets = config('secret-injector.secrets');

        foreach ($secrets as $key => $value) {
            SecretInjectorFacade::getSecret($key, $value, config('secret-injector.includedEnvs'));
        }
    }
}
