<?php

namespace Agz\LaravelGcpSecretInjector;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Agz\LaravelGcpSecretInjector\Facades\SecretInjector as SecretInjectorFacade;
use Illuminate\Support\Facades\Config;
use Illuminate\Foundation\Bootstrap\LoadConfiguration;

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
            ], 'gcp-secret-injector');
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
        if (is_array($secrets)) {
            foreach ($secrets as $key => $value) {
                SecretInjectorFacade::loadSecret($key, $value, config('secret-injector.includedEnvs'));
            }


            /**
             * After loading the environment, reload the configuration
             */
            $v = new LoadConfiguration();

            $v->bootstrap($this->app);
        }
    }
}
