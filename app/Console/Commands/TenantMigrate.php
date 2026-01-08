<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Artisan;

class TenantMigrate extends Command
{
    protected $signature = 'tenant:migrate';
    protected $description = 'Run tenant migrations';

    public function handle()
    {
        $tenants = DB::table('tenants')->get();

        foreach ($tenants as $tenant) {

            if(!$tenant->database){
                $this->error("Database not found for tenant ID {$tenant->id}");
                continue;
            }

            Config::set('database.connections.tenant.database', $tenant->database);
            DB::purge('tenant');
            DB::reconnect('tenant');

            $this->info("Migrating tenant DB: {$tenant->database}");

            Artisan::call('migrate', [
                '--database' => 'tenant',
                '--path' => database_path('migrations/tenant'),
                '--force' => true,
            ]);

            $this->line(Artisan::output());
        }
    }
}