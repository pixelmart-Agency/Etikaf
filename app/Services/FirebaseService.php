<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification as FirebaseNotification;

class FirebaseService
{
    private string $title;
    private string $body;
    private string|array|null $fcm_token;
    private array $data = [];

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function setBody(string $body): self
    {
        $this->body = $body;
        return $this;
    }

    public function setToken($fcm_token): self
    {
        $this->fcm_token = $fcm_token;
        return $this;
    }

    public function setData(array $data): self
    {
        $this->data = $data;
        return $this;
    }

    public function send()
    {
        try {
            // تهيئة Firebase يدويًا باستخدام ملف الخدمة
            $firebase = (new Factory())
                ->withServiceAccount(storage_path('app/firebase/fcm.json')) // تحديد مسار ملف JSON
                ->createMessaging();

            if (!isset($this->fcm_token)) {
                throw new \Exception('Device fcm_token is not set.');
            }

            // إعداد الإشعار
            $notification = FirebaseNotification::create($this->title, $this->body);
            $cloudMessage = CloudMessage::new()->withNotification($notification);
            $cloudMessage = $cloudMessage->withData($this->data);

            // إرسال الرسالة إلى جهاز واحد أو عدة أجهزة بناءً على نوع الفكرة
            if (is_array($this->fcm_token)) {
                $result = $firebase->sendMulticast($cloudMessage, $this->fcm_token);
            } else {
                $cloudMessage = $cloudMessage->toToken($this->fcm_token);
                $result = $firebase->send($cloudMessage);
            }

            // التحقق من نتيجة الإرسال


            return $result;
        } catch (\Exception $e) {
            activity()
                ->log('Notification not sent. Error: ' . $e->getMessage() . ' Trace: ' . $e->getTraceAsString());
            Log::error('Firebase send error: ' . $e->getMessage());
            return false;
        }
    }
}
