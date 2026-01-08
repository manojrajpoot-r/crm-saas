<?php

if (!function_exists('currentTenant')) {
    function currentTenant()
    {
        // Try route param first (recommended)
        if (request()->route('tenant')) {
            return request()->route('tenant');
        }


    }
}
