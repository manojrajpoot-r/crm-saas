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

        if (strtolower($user->role->name) === 'super-admin') {
            return true;
        }


        return $user->role->permissions
            ->pluck('group') // Users View, Users Add
            ->map(fn ($p) => strtolower(trim($p)))
            ->contains(strtolower(trim($permission)));
    }
}




