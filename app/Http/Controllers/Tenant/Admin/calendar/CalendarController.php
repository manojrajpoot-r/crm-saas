<?php

namespace App\Http\Controllers\tenant\admin\calendar;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tenant\Holiday;
use App\Models\Tenant\Leave;

class CalendarController extends Controller
{
public function index()
{
    $holidays = Holiday::where('status',1)->get()->map(fn($h)=>[
        'title' => '🎉 '.$h->title,
        'start' => $h->date,
        'color' => $h->is_optional ? '#ffc107' : '#28a745'
    ]);

    $leaves = Leave::with('user')->get()->map(fn($l)=>[
        'title' => '🧑 '.$l->user->name.' ('.$l->status.')',
        'start' => $l->start_date,
        'end'   => \Carbon\Carbon::parse($l->end_date)->addDay(),
        'color' => $l->status=='approved' ? '#0d6efd' : '#fd7e14'
    ]);

    return view('tenant.admin.calendars.index', [
        'events' => $holidays->merge($leaves)->values()
    ]);
}


}