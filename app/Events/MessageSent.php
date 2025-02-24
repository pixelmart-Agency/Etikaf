<?php

namespace App\Events;

use App\Http\Resources\SimpleUserResource;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $message;
    public $sender;
    public $channel;
    public $chat;

    public function __construct($message, $sender, $channel = null, $chat = null)
    {
        $this->message = $message;
        $this->sender = $sender;
        $this->channel = $channel;
        $this->chat = $chat;
    }

    public function broadcastOn()
    {
        // return new Channel('channel_' . $this->sender->id . '_' . $this->receiver->id);
        if ($this->channel) {
            return new Channel($this->channel);
        }
        return new Channel('channel_' . $this->sender->id);
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->chat->id,
            'sender_id' => $this->sender->id,
            'receiver_id' => $this->chat->receiver_id,
            'channel' => ($this->channel) ? $this->channel : 'channel_' . $this->sender->id,
            'message' => $this->message,
            'is_read' => (bool)$this->chat->is_read,
            'read_at' => $this->chat->read_at,
            'other_user' => $this->chat->otherUser != '-1' ? SimpleUserResource::make($this->chat->otherUser) : null,
            'other_user_id' => $this->chat->otherUser != '-1' ? $this->chat->otherUser->id : null,
            'created_since' => $this->chat->created_at->diffForHumans(),
            'other_user_image' => $this->sender->avatar_url,
            'time' => $this->chat->created_at->format('H:i'),
            'sender' => $this->sender->name,
            'sender_type' => $this->sender->user_type,
            // 'receiver' => $this->receiver->name,
            // 'channel' => 'channel_' . $this->sender->id . '_' . $this->receiver->id,
        ];
    }
}
