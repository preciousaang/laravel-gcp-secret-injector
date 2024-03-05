<?php


return [
    /**
     * CAUTION, do not use the get_secret function in here, might cause a loop
     * 
     */
    'project_id' => env('GCP_PROJECT_ID'),
    'includedEnvs' => ['local'],
    'secrets' => [
        'APP_ENV' => 'APP_ENV:latest',
        'DB_PASSWORD' => 'DB_PASSWORD:latest'
    ]
];
