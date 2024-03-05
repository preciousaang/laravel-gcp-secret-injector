<?php


return [

    'project_id' => env('GCP_PROJECT_ID'),
    'includedEnvs' => ['local'],
    'secrets' => [
        'APP_ENV' => 'APP_ENV:latest',
        'DB_PASSWORD' => 'DB_PASSWORD:latest'
    ]
];
