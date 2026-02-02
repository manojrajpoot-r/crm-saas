<?php
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
if (!function_exists('currentGuard')) {
    function currentGuard()
    {
        if (auth('web')->check()) return 'saas';
        if (auth('tenant')->check()) return 'tenant';
        return null;
    }
}





if (!function_exists('format_date')) {
    function format_date($date, $format = 'd M Y') {
        if (!$date) return '-';
        return Carbon::parse($date)->format($format);
    }
}

if (!function_exists('format_date_time')) {
    function format_date_time($date, $format = 'd M Y h:i A') {
        if (!$date) return '-';
        return \Carbon\Carbon::parse($date)->format($format);
    }
}

if (!function_exists('date_with_day_html')) {
    function date_with_day_html($date)
    {
        if (!$date) return '';

        $c = Carbon::parse($date);

        return sprintf(
            '%s <small class="text-muted d-block">%s%s</small>',
            format_date($date),
            $c->format('l'),
            $c->isWeekend() ? ' · Weekend' : ''
        );
    }
}