<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class SmsService
{
    protected $client;
    protected $apiKey;
    protected $sender;
    protected $apiSecret;
    protected $message;
    protected $recipient = [];
    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = env('4JAWALY_API_KEY', '5vBWZm7b4PuNTYR66f01fQlhzzhVOh9vRW7qceiN');
        $this->apiSecret = env('4JAWALY_SECRET', 'jyb8rbYRDg19i9LtC3INUoJ3CX6oFsuWj1kjGu6pwRBb8oJHAeWohXP6S7NjTkn2sCBAASjxrj5YCBVgSxdo2j5tGPKwqlO7MRdX');
        $this->getSender();
    }
    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }
    public function setRecipient($recipient)
    {
        $this->recipient[] = $recipient;
        return $this;
    }
    public function getSender()
    {

        $app_id = $this->apiKey;
        $app_sec = $this->apiSecret;
        $app_hash  = base64_encode("$app_id:$app_sec");
        $base_url = "https://api-sms.4jawaly.com/api/v1/";
        $query = [];
        $query["page_size"] = 10; // if you want pagination how many items per page
        $query["page"] = 1; // page number
        $query["status"] = 1; // get active 1 in active 2
        $query["sender_name"] = ''; // search sender name full name
        $query["is_ad"] = ''; // for ads 1 and 2 for not ads
        $query["return_collection"] = 1; // if you want to get collection for all not pagination
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $base_url . 'account/area/senders?' . http_build_query($query),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Accept: application/json',
                'Content-Type: application/json',
                'Authorization: Basic ' . $app_hash
            ),
        ));

        $response = curl_exec($curl);
        Log::info($response);

        $response = json_decode($response, true);
        if (isset($response['items'][0]['sender_name'])) {
            $sender = $response['items'][0]['sender_name'];
            curl_close($curl);
        } else {
            $sender = "Zimam.sa";
        }
        $this->sender = $sender;
    }

    public function sendSms()
    {
        try {
            $recipient = $this->formatSaudiMobile();

            $app_id = $this->apiKey;
            $app_sec = $this->apiSecret;
            $app_hash = base64_encode("{$app_id}:{$app_sec}");

            $messages = [
                "messages" => [
                    [
                        "text" => $this->message,
                        "numbers" => $recipient,
                        "sender" => $this->sender
                    ]
                ]
            ];

            $url = "https://api-sms.4jawaly.com/api/v1/account/area/sms/send";
            $headers = [
                "Accept: application/json",
                "Content-Type: application/json",
                "Authorization: Basic {$app_hash}"
            ];

            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($messages));
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            $response = curl_exec($curl);
            $status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            curl_close($curl);
            activity()->withProperties(['response' => $response])->log('SMS sent');
            // dd($response);
            $response_json = json_decode($response, true);
            Log::error($response_json['message']);
            activity()
                ->withProperties([
                    'mobile' => $recipient,
                    'message' => $this->message,
                    'data' => $response,
                    'sent_at' => now(),
                ])->log('SMS sent');
        } catch (\Exception $e) {
            activity()->withProperties(['error' => $e->getMessage()])->log('SMS sent');
            Log::error($e->getMessage());
            return false;
        }
    }

    private function formatSaudiMobile()
    {
        $recipient = [];
        foreach ($this->recipient as $number) {
            $recipient[] = $this->formatNumber($number);
        }
        return $recipient;
    }
    private function formatNumber($number)
    {

        $number = preg_replace('/\D/', '', $number);


        if (strlen($number) === 10 && strpos($number, '05') === 0) {
            return '966' . substr($number, 1);
        }

        if (strlen($number) === 9 && strpos($number, '5') === 0) {
            return '966' . $number;
        }

        return $number;
    }
}
