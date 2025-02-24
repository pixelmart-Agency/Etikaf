<?php

namespace App\Models;

use App\Enums\UserTypesEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Chat extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'message',
        'is_read',
        'read_at',
        'channel'
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public function scopeBetween($query, $userId1, $userId2)
    {
        return $query->where(function ($q) use ($userId1, $userId2) {
            $q->where('sender_id', $userId1)
                ->where('receiver_id', $userId2);
        })->orWhere(function ($q) use ($userId1, $userId2) {
            $q->where('sender_id', $userId2)
                ->where('receiver_id', $userId1);
        });
    }
    public function scopeGroupedByLastMessage($query)
    {
        return $query->with(['sender', 'receiver'])
            ->latest('id')
            ->get()
            ->groupBy('channel')
            ->map(function ($chats) {
                $lastMessage = $chats->sortByDesc('id')->first();

                $unreadCount = $chats->where('is_read', false)
                    ->where('sender_id', '!=', user_id())
                    ->count();

                $lastMessage->unread_message_count = $unreadCount;

                return $lastMessage;
            });
    }
    public function scopeInvolving($query, $userId)
    {
        return $query->where('sender_id', $userId)
            ->orWhere('receiver_id', $userId);
    }

    public function markAsRead()
    {
        $this->update([
            'is_read' => true,
            'read_at' => now(),
        ]);
    }

    public function isRead()
    {
        return $this->is_read;
    }

    public function isSentBy($userId)
    {
        return $this->sender_id === $userId;
    }

    public function isReceivedBy($userId)
    {
        return $this->receiver_id === $userId;
    }
    public function getOtherUserAttribute()
    {
        $userId = explode('_', $this->channel)[1];
        $user = User::find($userId);
        if (user()->user_type == UserTypesEnum::USER->value) {
            return "-1";
        }
        return $user;
    }
    public function getOtherUserIdAttribute()
    {
        return $this->sender->user_type != UserTypesEnum::USER->value
            ? explode('_', $this->channel)[1]
            : $this->sender_id;
    }
}
