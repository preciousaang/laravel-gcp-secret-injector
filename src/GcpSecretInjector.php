<?php

namespace Agz\LaravelGcpSecretInjector;



class GcpSecretInjector implements SecretInjector
{


    private $client;

    public function __construct()
    {
    }

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
     * @return mixed
     */
    public  function getSecret($secretName, $version = "latest")
    {
    }
}