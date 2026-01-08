<?php
use Illuminate\Support\Facades\Auth;

if (!function_exists('currentGuard')) {
    function currentGuard()
    {
        if (auth('web')->check()) return 'saas';
        if (auth('tenant')->check()) return 'tenant';
        return null;
    }
}

