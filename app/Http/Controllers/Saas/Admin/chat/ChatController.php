<?php

namespace App\Http\Controllers\Saas\Admin\chat;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Message;
use App\Models\Conversation;
use App\Http\Requests\SendMessageRequest;
use App\DTOs\SendMessageDTO;
use App\Actions\SendMessageAction;
use Illuminate\Support\Facades\Auth;
class ChatController extends Controller
{



public function index(User $user = null)
{
    $authId = Auth::guard('web')->id();

    // 1️⃣ Sidebar users
    $users = User::where('id', '!=', $authId)->get();

    $conversation = null;
    $messages = collect();

    // 2️⃣ Agar user select kiya
    if ($user) {

        // Conversation find
        $conversation = Conversation::whereHas('users', function ($q) use ($authId) {
            $q->where('user_id', $authId);
        })->whereHas('users', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->first();

        // Create if not exists
        if (!$conversation) {
            $conversation = Conversation::create();
            $conversation->users()->attach([$authId, $user->id]);
        }

        // Messages load
        $messages = $conversation->messages()
            ->with('sender')
            ->orderBy('id')
            ->get();

        // ✅ Mark received messages as read
        Message::where('conversation_id', $conversation->id)
            ->where('sender_id', '!=', $authId)
            ->update(['is_read' => 1]);
    }

    // 3️⃣ Unread count per user (NO receiver_id)
    $users = $users->map(function ($u) use ($authId) {

        $conversation = Conversation::whereHas('users', function ($q) use ($authId) {
                $q->where('user_id', $authId);
            })
            ->whereHas('users', function ($q) use ($u) {
                $q->where('user_id', $u->id);
            })
            ->first();

        $u->unread_count = $conversation
            ? Message::where('conversation_id', $conversation->id)
                ->where('sender_id', $u->id)
                ->where('is_read', 0)
                ->count()
            : 0;

        return $u;
    });

    return view('tenant.admin.chat.index', compact(
        'users',
        'conversation',
        'messages',
        'user'
    ));
}




    public function send(SendMessageRequest $request, SendMessageAction $action) {
        $action->execute(SendMessageDTO::fromRequest($request));
        return response()->json(true);
    }
}