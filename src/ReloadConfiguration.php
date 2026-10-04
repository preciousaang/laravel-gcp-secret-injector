<?php

namespace Agz\LaravelGcpSecretInjector;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Bootstrap\LoadConfiguration;

class ReloadConfiguration extends LoadConfiguration
{
    public function reload(Application $app)
    {
        $this->loadConfigurationFiles($app, $app->make('config'));
    }
}