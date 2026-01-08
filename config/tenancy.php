<?php

use App\Models\Tenant;
use Stancl\Tenancy\UUIDGenerator;

return [

    'tenant_model' => Tenant::class,
    'id_generator' => UUIDGenerator::class,

    'migrations' => [
        'tenant' => [
            database_path('tenant/migrations'),
        ],
    ],

    'database' => [
        'central_connection' => env('DB_CONNECTION', 'mysql'),
        'prefix' => 'tenant_',
        'suffix' => '',
        'tenants_are_isolated_by_database' => true,
        'auto_create_database' => true,

        'managers' => [
            'mysql' => \Stancl\Tenancy\Database\Managers\MySQLDatabaseManager::class,
        ],
    ],

];