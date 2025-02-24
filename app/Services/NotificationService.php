<?php

namespace App\Services;

use App\Models\User;

class NotificationService
{
    public function getNotifications(int $userId, int $perPage = 10)
    {
        $user = User::find($userId);
        if (!$user) {
            return null;
        }
        return $user->notifications()->filter()->paginate($perPage);
    }
    public function getNotificationsCount(int $userId)
    {
        $user = User::find($userId);
        if (!$user) {
            return null;
        }
        return $user->notifications()->count();
    }
    public function getUnreadNotificationsCount(int $userId)
    {
        $user = User::find($userId);
        if (!$user) {
            return null;
        }
        return $user->notifications()->unread()->count();
    }
    public function markAsRead(int $userId, ?array $notificationIds)
    {
        $user = User::find($userId);
        if (!$user) {
            return null;
        }
        $notifications = $user->notifications();
        if ($notificationIds) {
            $notifications->whereIn('id', $notificationIds);
        }
        return $notifications->get()->each->markAsRead();
    }
}
