<?php

namespace App\DTOs;

use App\Http\Requests\SendMessageRequest;
use Illuminate\Support\Facades\Auth;
class SendMessageDTO
{
    public int $conversationId;
    public int $senderId;
    public string $message;

    public function __construct(
        int $conversationId,
        int $senderId,
        string $message
    ) {
        $this->conversationId = $conversationId;
        $this->senderId = $senderId;
        $this->message = $message;
    }

    public static function fromRequest(SendMessageRequest $request): self
    {
          $auth_id = Auth::guard('web')->id();
        return new self(
            $request->conversation_id,
             $auth_id,
            $request->message
        );
    }
}
