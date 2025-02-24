<?php

namespace App\Jobs;

use App\Enums\UserTypesEnum;
use App\Models\User;
use App\Notifications\NewMessageNotification;
use App\Services\FirebaseService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendNewMessageNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $senderName;
    protected $message;
    protected $receiverIds;

    public function __construct($senderName, $message, $receiverIds)
    {
        $this->senderName = $senderName;
        $this->message = $message;
        $this->receiverIds = $receiverIds;
    }
    public function handle()
    {
        $receivers = User::whereIn('id', $this->receiverIds)
            ->where('notification_enabled', true)
            ->whereNotNull('fcm_token')->get();

        if ($receivers->isEmpty()) {
            return;
        }

        $tokens = $receivers->pluck('fcm_token')->toArray();

        $firebaseService = new FirebaseService();
        $firebaseService->setTitle('New Message')
            ->setBody($this->message)
            ->setData([
                'type' => 'new_message',
                'sender_name' => $this->senderName,
                'message' => $this->message,
            ])
            ->send(); // إرسال إشعار واحد لجميع المستخدمين دفعة واحدة

        // تخزين الإشعارات في قاعدة البيانات
        foreach ($receivers as $receiver) {
            if ($receiver->user_type == UserTypesEnum::EMPLOYEE->value && !$receiver->hasPermissionTo('chat'))
                continue;
            $receiver->notify(new NewMessageNotification($this->senderName, $this->message, $receiver));
        }
    }
}
