<?php

namespace App\Actions;

use App\DTOs\SendMessageDTO;
use App\Models\Message;
use App\Events\MessageSent;

class SendMessageAction
{
    public function execute(SendMessageDTO $dto): void
    {
        $message = Message::create([
            'conversation_id' => $dto->conversationId,
            'sender_id'       => $dto->senderId,
            'message'         => $dto->message,
        ]);

        broadcast(new MessageSent($message))->toOthers();
    }
}