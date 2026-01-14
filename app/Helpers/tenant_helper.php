<?php

if (!function_exists('currentTenant')) {
    function currentTenant()
    {
        return config('saas.current_tenant');
    }
}