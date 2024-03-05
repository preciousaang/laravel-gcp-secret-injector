<?php

namespace Agz\LaravelGcpSecretInjector;



interface SecretInjector
{

    /**
     * Get a secret version payload 
     * 
     * 
     * @param string $secretName
     * The name of the secret
     * 
     * @param string $version
     * The secret version
     * 
     * @param array $includedEnvs
     * Environments to exclude when running the method. 
     * The environment to this method for
     * 
     * @return mixed
     */
    public function getSecret($secretName, $version = "latest", $includedEnvs = ['production']);


    public function loadSecret($envName, $secret);
}
