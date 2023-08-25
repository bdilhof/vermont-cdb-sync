<?php

return [
    'connection' => [
        'url' => env('CDB_URL', 'https://cdb.vermont.eu/api/universal'),
        'ssl_verify' => env('CDB_SSL_VERIFY', true),
        'secret' => env('CDB_SECRET', ''),
        'key' => env('CDB_KEY', ''),
    ]
];
