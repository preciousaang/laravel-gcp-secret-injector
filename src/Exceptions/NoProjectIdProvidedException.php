<?php

namespace Agz\LaravelGcpSecretInjector\Exceptions;

use Exception;

class NoProjectIdProvidedException extends Exception
{
    protected $message = 'No project id provided. Please provided the \'project_id\' key in the $options param of the constructor';
}