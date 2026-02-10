<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use App\Providers\TenantUserProvider;
use Illuminate\Pagination\Paginator;

class RouteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {

        parent::boot();
         Paginator::useBootstrapFive();
        $this->routes(function () {
            // Tenant routes
            Route::middleware(['web', 'tenant'])
                ->group(base_path('routes/tenant.php'));

            // Web routes
            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });


    }

}