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
