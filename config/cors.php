<?php

return [
    'paths' => ['api/*', 'v1/*', 'sanctum/csrf-cookie'],
    'allowed_methods' => ['*'],
    'allowed_origins' => ['http://localhost:3000', 'https://api.nfse.io/v2/companies'],
    'allowed_headers' => ['Content-Type', 'X-CSRF-TOKEN', 'Authorization'],
    'supports_credentials' => true,
];