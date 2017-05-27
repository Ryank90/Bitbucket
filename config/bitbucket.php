<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the connections below you wish to use as
    | your default connection for all work. Of course, you may use many
    | connections at once using the manager class.
    |
    */

    'default' => 'main',

    /*
    |--------------------------------------------------------------------------
    | Bitbucket Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the connections setup for your application. Example
    | configuration has been included, but you may add as many connections as
    | you would like. Note that the two supported authentication methods are:
    | "basic", and "token".
    |
    */

    'connections' => [

        'main' => [
            'token'   => 'your-token',
            'method'  => 'token',
            // 'logging' => false,
            // 'baseUrl' => 'https://api.bitbucket.org',
            // 'version' => '1.0',
            // 'verify'  => true,
        ],

        'alternative' => [
            'username' => 'your-username',
            'password' => 'your-password',
            'method'   => 'basic',
            // 'logging'  => false,
            // 'baseUrl'  => 'https://api.bitbucket.org',
            // 'version'  => '1.0',
            // 'verify'   => true,
        ],

    ],

];
