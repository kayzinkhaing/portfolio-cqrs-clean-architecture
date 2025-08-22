<?php

return [
    'paths' => ['api/*', 'graphql', 'sanctum/csrf-cookie'], // <-- add 'graphql' here
    'allowed_methods' => ['*'],
    'allowed_origins' => ['http://localhost:5173'],
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => true,
];


