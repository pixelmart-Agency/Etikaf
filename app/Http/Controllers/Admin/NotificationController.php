<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use App\Models\Activity as ModelsActivity;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = unreadNotifications(false, true);
        $latestNotification = Activity::orderBy('created_at', 'desc')->first();
        if ($latestNotification) {
            $this->markNotificationAsRead($latestNotification->id);
        }
        return view('admin.notifications.index', compact('notifications'));
    }
    public function index_all()
    {
        $notifications = allNotifications();

        return view('admin.notifications.index', compact('notifications'));
    }
    public function markAsRead(Request $request)
    {
        $latestNotification = ModelsActivity::query()->displayable()->first();
        $this->markNotificationAsRead($latestNotification->id);

        return response()->json(['status' => 'Notification marked as read']);
    }
    public function markNotificationAsRead($id)
    {
        $notification = Activity::find($id);
        if (!$notification) {
            return false;
        }
        $properties = $notification->properties ?? [];
        $properties['is_read'] = true;
        $notification->update(['properties' => $properties]);
        return true;
    }
}
