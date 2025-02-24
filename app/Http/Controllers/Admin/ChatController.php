<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\UserResource;
use App\Http\Resources\ChatResource;
use App\Models\User;
use App\Services\ChatService;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    protected $chatService;

    public function __construct(ChatService $chatService)
    {
        $this->chatService = $chatService;
    }
    public function index()
    {

        // Get the count of chats for the authenticated user
        $chats_count = $this->chatService->getChatsCount();
        // Retrieve the plain chat data grouped by chat
        $chatsPlain = $this->chatService->getGroupedChats();
        // Transform chats using a resource and convert them to an array
        $chats = ChatResource::collection($chatsPlain)->toArray(request());

        // Ensure that chatsPlain is not empty before proceeding
        $firstChat = $chatsPlain->first();
        if ($firstChat) {
            // Get chat data between the first other user and the authenticated user
            $chatsBetweenUsers = $this->chatService->getChatBetweenUsers(
                $firstChat->channel,
                'asc'
            );

            // Mark messages as read for the given chat between users
            $this->chatService->markMessagesAsRead(user_id(), optional($firstChat->otherUser)->id);

            // Group chats by the date they were created
            $chatsGroupedByDate = $chatsBetweenUsers->groupBy(function ($chat) {
                return $chat->created_at->format('m/d/Y');
            });

            // Retrieve the last user id in the chat list for the view
            $lastUserId = $firstChat->other_user_id;
        } else {
            // Handle the case where there are no chats
            $chatsGroupedByDate = collect(); // Empty collection if no chats exist
            $lastUserId = null; // No user ID if no chats exist
        }

        // Return the view with the necessary data
        return view('admin.chat.index', compact('chats_count', 'chats', 'chatsGroupedByDate', 'lastUserId'));
    }


    public function getChat($channel)
    {
        try {
            $chats = $this->chatService->getChatBetweenUsers($channel, 'asc');
            foreach ($chats as $chat) {
                $chat->sender->avatar_url = imageUrl($chat->sender->avatar_url);
            }
            $chats = $chats->groupBy(function ($chat) {
                return $chat->created_at->format('Y/m/d');
            });
            $this->chatService->markMessagesAsRead(user_id(), $channel);

            return response()->json($chats);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
    public function save(Request $request)
    {
        try {
            $chat = $this->chatService->sendMessage($request->channel, $request->message);
            $userId = explode('_', $request->channel)[1];
            $user = User::find($userId);
            if ($user->is_notifiable)
                $user->notify(new \App\Notifications\NewMessageNotification($user->name, $request->message, $user));
            return response()->json($chat);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
