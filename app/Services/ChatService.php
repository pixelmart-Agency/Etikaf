<?php

namespace App\Services;

use App\Enums\UserTypesEnum;
use App\Events\MessageSent;
use App\Models\Chat;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChatService
{
    public function sendMessage($channel = null, $messageContent = null, $isTransaction = true)
    {
        if ($isTransaction) {
            return DB::transaction(function () use ($channel, $messageContent) {
                return $this->sendMessage($channel, $messageContent, false);
            });
        }
        $sender = Auth::user();

        $chat = Chat::create([
            'sender_id' => $sender->id,
            'receiver_id' => null,
            'message' => $messageContent,
            'channel' => $channel,
        ]);

        broadcast(new MessageSent($chat->message, $sender, $channel, $chat))->toOthers();

        return $chat;
    }

    public function getChatBetweenUsers($channel, $sort = 'desc')
    {
        return Chat::with(['receiver', 'sender'])
            ->where('channel', $channel)
            ->orderBy('created_at', $sort)->get();
    }

    public function getChatGroupedByDate($channel)
    {
        if (user()->user_type == UserTypesEnum::EMPLOYEE->value && !user()->hasPermissionTo('chat'))
            return [];
        else
            return Chat::with(['receiver', 'sender'])
                ->where('channel', $channel)
                ->orderBy('created_at', 'desc');
    }



    public function markAsRead($chatId)
    {
        $chat = Chat::findOrFail($chatId);

        if (!$chat->is_read) {
            $chat->markAsRead();
        }

        return $chat;
    }

    public function getUnreadMessages($userId)
    {
        return Chat::where('receiver_id', $userId)->unread()->get();
    }
    public function getGroupedChats()
    {
        if (user()->user_type == UserTypesEnum::EMPLOYEE->value && !user()->hasPermissionTo('chat'))
            return [];
        else
            return Chat::groupedByLastMessage();
    }
    public function getChatsCount()
    {
        return Chat::distinct('channel')
            ->count('channel');
    }
    public function markMessagesAsRead($userId, $channel)
    {
        if (is_integer($channel)) {
            $channel = 'channel_' . $channel;
        }
        return Chat::where('sender_id', '!=', $userId)
            ->where('channel', $channel)
            ->update(['is_read' => 1, 'read_at' => Carbon::now()]);
    }
}
