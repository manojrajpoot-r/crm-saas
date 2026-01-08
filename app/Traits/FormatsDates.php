<?php

namespace App\Traits;

use Carbon\Carbon;

trait FormatsDates
{
    public function formatDate($date, $format = 'd M Y')
    {
        if (!$date) {
            return '-';
        }

        return Carbon::parse($date)->format($format);
    }

    public function formatDateTime($date, $format = 'd M Y h:i A')
    {
        if (!$date) {
            return '-';
        }

        return Carbon::parse($date)->format($format);
    }
}