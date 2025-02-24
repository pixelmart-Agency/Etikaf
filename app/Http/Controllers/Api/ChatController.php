<?php

namespace App\Http\Controllers\Api;

use App\Enums\UserTypesEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\ChatResource;
use App\Jobs\SendNewMessageNotification;
use App\Models\Chat;
use App\Models\User;
use App\Notifications\NewMessageNotification;
use App\Responses\ErrorResponse;
use App\Responses\SuccessResponse;
use App\Services\ChatService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\LengthAwarePaginator;

class ChatController extends Controller
{
    protected $chatService;

    public function __construct(ChatService $chatService)
    {
        $this->chatService = $chatService;
    }

    public function send(Request $request)
    {
        try {
            $request->validate([
                'message' => 'required|string',
            ]);
            $channel = user()->user_type == UserTypesEnum::USER->value ? 'channel_' . user_id() : request()->channel;
            $chat = $this->chatService->sendMessage($channel, $request->message);
            if (user()->user_type == UserTypesEnum::USER->value) {
                $receivers = User::where('user_type', '!=', UserTypesEnum::USER->value)
                    ->where('notification_enabled', true)
                    ->where('fcm_token', '!=', NULL)
                    ->where('fcm_token', '!=', '')
                    ->where('fcm_token', '!=', 'null')
                    ->where('is_active', true)
                    ->pluck('id');
                dispatch(new SendNewMessageNotification(Auth::user()->name, $request->message, $receivers));
            } else {
                $userId = explode('_', $channel)[1];
                $receivers = User::where('id', $userId)
                    ->where('notification_enabled', true)
                    ->where('fcm_token', '!=', NULL)
                    ->where('fcm_token', '!=', '')
                    ->where('fcm_token', '!=', 'null')
                    ->where('is_active', true)
                    ->pluck('id');
                dispatch(new SendNewMessageNotification(__('translation.support_user'), $request->message, $receivers, false));
            }
            if (user()->user_type == UserTypesEnum::USER->value) {
                activity()
                    ->performedOn($chat)
                    ->causedBy(Auth::user())
                    ->withProperties([
                        'message' => $request->message,
                        'sender_id' => Auth::user()->id,
                        'sender_name' => Auth::user()->name,
                    ])
                    ->log('New message');
            }

            return SuccessResponse::send(ChatResource::make($chat), __('translation.message_sent'), 200);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ErrorResponse::send($e->getMessage(), 400);
        }
    }




    public function getChatBetweenUsers(Request $request)
    {
        $perPage = $request->input('per_page', 10); // عدد الرسائل في الصفحة
        $currentPage = $request->input('page', 1);  // الصفحة الحالية
        $channel = user()->user_type == UserTypesEnum::USER->value ? 'channel_' . user_id() : request()->channel;
        $total = Chat::where('channel', $channel)->count();
        $chats = $this->chatService->getChatGroupedByDate($channel)->paginate($perPage); // استخدام get() بدلاً من paginate()

        // تجميع الرسائل حسب التاريخ
        $groupedChats = $chats->groupBy(function ($chat) {
            return $chat->created_at->format('Y-m-d');
        })
            ->map(function ($group, $date) {
                return [
                    'date' => $date,
                    'messages' => ChatResource::collection($group)
                ];
            })
            ->values(); // لضبط ترتيب النتائج

        // حساب التصفية يدويًا
        $this->chatService->markMessagesAsRead(user_id(), $channel);
        // معلومات التصفح بدون روابط
        $pagination = [
            'current_page' => $currentPage,
            'last_page' => (int) ceil($total / $perPage),
            'per_page' => $perPage,
            'total' => $total,
        ];

        return SuccessResponse::send(
            [
                'data' => $groupedChats,
                'pagination' => $pagination
            ],
            __('translation.messages_found'),
            200
        );
    }






    public function markAsRead(Request $request, $chatId)
    {
        $chat = $this->chatService->markAsRead($chatId);

        return SuccessResponse::send(ChatResource::make($chat), __('translation.message_marked_as_read'), 200);
    }

    public function getUnreadMessages(Request $request, $userId)
    {
        $unreadMessages = $this->chatService->getUnreadMessages($userId);

        return SuccessResponse::send(ChatResource::collection($unreadMessages), __('translation.unread_messages_found'), 200);
    }
    public function getGroupedChats(Request $request)
    {
        $chats = $this->chatService->getGroupedChats(Auth::user()->id);

        // Convert the associative array into a numerically indexed array
        $data = ChatResource::collection($chats);
        $data = array_values($data->toArray(request())); // Use toArray() if $chats is a collection

        // Prepare the final response

        // Return the response
        return SuccessResponse::send($data, __('translation.messages_found'), 200);
    }
}
