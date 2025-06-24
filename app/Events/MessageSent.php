<?php

namespace App\Events;

use App\Models\ChatMessage;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public ChatMessage $message;

    public function __construct(ChatMessage $message)
    {
        $this->message = $message;
    }

    public function broadcastOn(): array
    {
        $channels = [];

        if ($this->message->message_type === 'group' && $this->message->group_id) {
            // Diffuser vers le canal du groupe
            $channels[] = new PrivateChannel('group.' . $this->message->group_id);
        } else {
            // Diffuser vers les canaux privés (chat privé existant)
            $channels[] = new PrivateChannel('chat.' . $this->message->sender_id);
            $channels[] = new PrivateChannel('chat.' . $this->message->receiver_id);
        }

        return $channels;
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->message->id,
            'sender_id' => $this->message->sender_id,
            'receiver_id' => $this->message->receiver_id,
            'group_id' => $this->message->group_id,
            'message' => $this->message->message,
            'message_type' => $this->message->message_type,
            'created_at' => $this->message->created_at,
        ];
    }
}
