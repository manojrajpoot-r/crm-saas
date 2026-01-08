<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use App\Providers\TenantUserProvider;
class AuthServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Register custom tenant provider
        Auth::provider('tenant', function ($app, array $config) {
          return new TenantUserProvider();
        });
    }
}




