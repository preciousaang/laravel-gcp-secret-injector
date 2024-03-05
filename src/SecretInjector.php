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
     * @param array $excludedEnvs
     * Environments to exclude when running the method. 
     * If the method is called in the environment, an empty string is returned
     * 
     * @return mixed
     */
    public function getSecret($secretName, $version = "latest", $excludedEnvs = ['local', 'testing']);
}