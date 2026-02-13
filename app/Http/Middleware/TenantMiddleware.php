<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;
use App\Models\Tenant;
use App\Models\Domain;

class TenantMiddleware
{
    public function handle($request, Closure $next)
    {
        $host = $request->getHost();

        // SaaS
        if ($host === 'crm.saas.local') {
            config(['saas.current_tenant' => null]);
            return $next($request);
        }

        $domain = Domain::where('domain', $host)
            ->where('is_active', 1)
            ->first();

        abort_if(!$domain, 404, 'Tenant domain not found');

        $tenant = Tenant::where('id', $domain->tenant_id)
            ->where('status', 1)
            ->firstOrFail();

        config(['database.connections.tenant.database' => $tenant->database]);
        config(['database.default' => 'tenant']);
        DB::purge('tenant');
        DB::reconnect('tenant');

        config(['saas.current_tenant' => $tenant]);

        return $next($request);
    }
}
