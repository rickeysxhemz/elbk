<?php
// config/session.php
// Copy here directly from laravel, and use the file driver, of course, you can also use other drivers, please refer to the official laravel documentation for detailed configuration
return [
    'driver' => env('SESSION_DRIVER', 'file'), // The file driver is used by default, you can configure it in .env
    'lifetime' => 35791394, // Cache invalidation time, in minutes
    'expire_on_close' => false,
    'encrypt' => false,
    'files' => storage_path('framework/session'), // file cache save path
    'connection' => null,
    'table' => 'sessions',
    'lottery' => [2, 100],
    'cookie' => 'laravel_session',
    'path' => '/',
    'domain' => null,
    'secure' => false,
];