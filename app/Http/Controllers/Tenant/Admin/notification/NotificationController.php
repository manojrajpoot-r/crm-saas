<?php

namespace App\Http\Controllers\Tenant\Admin\notification;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tenant\Notification;
use Illuminate\Support\Facades\Auth;
class NotificationController extends Controller
{
public function index()
{


    return Notification::where('user_id', Auth::id())
        ->latest()
        ->take(10)
        ->get()
        ->map(function ($n) {
            return [
                'id'      => $n->id,
                'title'   => $n->title,
                'message' => $n->message,
                'read_at' => $n->read_at,
                'user'    => [
                    'name' => Auth::user()->name,
                    'image' => Auth::user()->profile
                        ? asset('uploads/tenantusers/profile/' . Auth::user()->profile)
                        : null,

                ]
            ];
        });
}


    public function unreadCount()
    {
       return Notification::where('user_id', Auth::id())
            ->whereNull('read_at')
            ->count();

    }

    public function markRead($id)
    {
        Notification::where('id', $id)
            ->where('user_id', Auth::id())
            ->update(['read_at' => now()]);

        return response()->json(['success' => true]);
    }

    public function markAllRead()
    {
        Notification::where('user_id', Auth::id())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return response()->json(['success' => true]);
    }
}