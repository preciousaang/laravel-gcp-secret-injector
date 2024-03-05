<?php

namespace Agz\LaravelGcpSecretInjector;

use Agz\LaravelGcpSecretInjector\Exceptions\NoProjectIdProvidedException;
use Google\Cloud\SecretManager\V1\Client\SecretManagerServiceClient;

class GcpSecretInjector implements SecretInjector
{


    private $client;
    private $projectId;

    public function __construct($options = [])
    {
        if (!isset($options['project_id'])) {
            throw new NoProjectIdProvidedException();
        }

        $this->client = new SecretManagerServiceClient();
        $this->projectId = $options['project_id'];
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
    public  function getSecret($secretName, $version = "latest", $excludedEnvs = ['local', 'testing'])
    {


        if (env('APP_ENV') && in_array(env('APP_ENV'), $excludedEnvs)) {
            return '';
        }

        if (array_key_exists("$secretName:$version", $_ENV)) {
            return $_ENV["$secretName:$version"];
        }

        $name = $this->client->secretVersionName(
            $this->projectId,
            $secretName,
            $version,
        );
    }
}