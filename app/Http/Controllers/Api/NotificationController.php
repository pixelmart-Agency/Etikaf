<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationResource;
use App\Responses\SuccessResponse;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }
    public function index()
    {
        $perPage = request()->get('per_page', 10);
        $notifications = $this->notificationService->getNotifications(Auth::id(), $perPage);
        $notifications = NotificationResource::collection($notifications);
        return SuccessResponse::send($notifications, __('translation.notifications_found'), 200, true);
    }
    public function getNotificationsCount()
    {
        $userId = Auth::id();
        $count = $this->notificationService->getNotificationsCount($userId);
        return SuccessResponse::send($count, __('translation.notifications_found'), 200);
    }
    public function getUnreadNotificationsCount()
    {
        $userId = Auth::id();
        $count = $this->notificationService->getUnreadNotificationsCount($userId);
        return SuccessResponse::send($count, __('translation.notifications_found'), 200);
    }
    public function markAsRead()
    {
        $notificationIds = request()->get('notification_ids');
        $this->notificationService->markAsRead(Auth::id(), $notificationIds);
        return SuccessResponse::send(1, __('translation.notifications_marked_as_read'), 200);
    }
}
