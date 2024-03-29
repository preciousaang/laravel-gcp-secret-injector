<?php

namespace Agz\LaravelGcpSecretInjector;

use Agz\LaravelGcpSecretInjector\Exceptions\NoProjectIdProvidedException;
use Google\ApiCore\ApiException;
use Google\Cloud\SecretManager\V1\AccessSecretVersionRequest;
use Google\Cloud\SecretManager\V1\Client\SecretManagerServiceClient;
use Illuminate\Support\Facades\Artisan;

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
     * @param array $includedEnvs
     * Environments to exclude when running the method. 
     * If the method is called in the environment, an empty string is returned
     * 
     * @return mixed
     */
    public  function getSecret($secretName, $version = "latest", $includedEnvs = ['production'])
    {


        if (!env('APP_ENV') || !in_array(env('APP_ENV'), $includedEnvs)) {
            return '';
        }

        if (array_key_exists("$secretName:$version", $_ENV)) {
            return $_ENV["$secretName:$version"];
        }

        try {


            $name = $this->client->secretVersionName(
                $this->projectId,
                $secretName,
                $version,
            );

            $request = AccessSecretVersionRequest::build($name);
            $response = $this->client->accessSecretVersion($request);


            $payload = $response->getPayload()->getData();
            $_ENV["$secretName:$version"] = $payload;
            return $payload;
        } catch (ApiException $e) {
            report($e);
        }
    }


    public function loadSecret($envName, $secret)
    {
        if (is_null(env($envName)) || env($envName) == '') {
            $segments = explode(":", $secret);
            if (count($segments) !== 2) {
                throw new \Exception("Secret must be written in the format SECRET_NAME:VERSION");
            }

            $secretName = $segments[0];
            $secretVersion =  $segments[1];

            $secretPayload =  $this->getSecret($secretName, $secretVersion, config('secret-injector.includedEnvs'));

            $_ENV[$envName] = $secretPayload;
        }
    }
}
