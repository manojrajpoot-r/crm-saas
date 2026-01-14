<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
class MessageSent implements ShouldBroadcast
{
    use Dispatchable, SerializesModels;
    public $queue = 'chat';
    public function __construct(public Message $message)
    {
    }

    public function broadcastOn(): PrivateChannel
    {
        return new PrivateChannel(
            'chat.' . $this->message->conversation_id
        );
    }
}
