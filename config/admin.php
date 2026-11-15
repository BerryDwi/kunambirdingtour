<?php

$isProduction = env('APP_ENV', 'production') === 'production';

return [
    /*
    |--------------------------------------------------------------------------
    | Administrator Account
    |--------------------------------------------------------------------------
    |
    | Credentials used by the AdminUserSeeder. In local and testing
    | environments a development fallback is provided so seeding works
    | without additional configuration. Production must define both
    | ADMIN_EMAIL and ADMIN_PASSWORD explicitly.
    |
    */

    'name' => env('ADMIN_NAME', 'Administrator'),

    'email' => env('ADMIN_EMAIL', $isProduction ? null : 'admin@birdtourasia.com'),

    'password' => env('ADMIN_PASSWORD', $isProduction ? null : 'password'),
];
