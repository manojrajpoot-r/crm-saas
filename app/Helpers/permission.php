<?php

use Illuminate\Support\Facades\Auth;

if (!function_exists('canAccess')) {
    function canAccess($permission)
    {

        if (Auth::guard('tenant')->check()) {
            $user = Auth::guard('tenant')->user();
        } elseif (Auth::guard('web')->check()) {
            $user = Auth::guard('web')->user();
        } else {
            return false;
        }

        if (!$user || !$user->role) {
            return false;
        }

        if ($user->master == 1) {
            return true;
        }


        return $user->role->permissions
            ->pluck('name')
            ->map(fn ($p) => strtolower(trim($p)))
            ->contains(strtolower(trim($permission)));
    }
}
