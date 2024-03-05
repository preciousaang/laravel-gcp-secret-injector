<?php

namespace Agz\LaravelGcpSecretInjector\Facades;

use Illuminate\Support\Facades\Facade;


/**
 * @method static \Agz\LaravelGcpSecretInjector\GcpSecretInjector getSecret($secretName, $version='latest', $includedEnvs=['production'])
 * 
 *  @method static \Agz\LaravelGcpSecretInjector\GcpSecretInjector ($envName, $secret)
 */
class SecretInjector extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'agz-gcp-secret-injector';
    }
}
