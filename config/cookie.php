<?php

return [
    'path' => '/',
    'domain' => env('SESSION_DOMAIN'),
    'secure' => env('SESSION_SECURE_COOKIES', false),
    'http_only' => true,
    'same_site' => 'lax',
    'partitioned' => false,
];
