# Load secrets into your environmental variable without declaring it in your .env

This package helps load sensitive data from you Google Cloud Secret Manager into your laravel environment instead of explictly defining it in your .env file.

## Installation

You can install this package via composer:

```
composer require agz/laravel-secret-injector
```

To publish the config file run the vendor publish command:

```
php artisan vendor:publish --tag=gcp-secret-injector
```

## Configuration

After publishing the secret inject assets, its configuration will be located at config/secret-injector.php. The configuration allows you to configure you environmental variables against the your Google Cloud secrets.

```
return [

    'project_id' => env('GOOGLE_CLOUD_PROJECT'),
    'includedEnvs' => ['production'],
    'secrets' => []
];

```

The `project_id` points to your google cloud project id. The `includedEnvs` tells configures what environments which you want the library to be active. For example, by default is configured to be just production. Meaning that once your APP_ENV is set to production, then the library will pull secrets from your Google Cloud Secret Manager in to your environment.

The `secrets` is used to configure what environmental variables should point to which secrets.

```
'secrets' => [
        'ENVIROMENTAL_VARIABLE' => 'SECRET_NAME:VERSION',
    ]
```

For example:

```
'secrets' => [
        'APP_KEY' => 'APP_KEY:latest',
        'DB_PASSWORD' => 'DB_PASSWORD:1',
    ]
```

## Testing

```
composer test
```

## Contributors

-   [Precious Ibeagi](https://github.com/preciousaang)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
