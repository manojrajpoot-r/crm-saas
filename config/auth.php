<?php
return [

    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],




'guards' => [
    'web' => [
        'driver' => 'session',
        'provider' => 'tenant_users',
    ],








        'tenant' => [
            'driver' => 'session',
            'provider' => 'tenant_users',
        ],

        // API token auth for tenant users (Sanctum)
        'api' => [
            'driver' => 'sanctum',
            'provider' => 'tenant_users',
        ],
    ],

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],

        'tenant_users' => [
            'driver' => 'eloquent',
            'model' => App\Models\Tenant\TenantUser::class,
        ],
    ],

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => 10800,
];
