<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use MohamadZatar\Nafath\Models\NafathLogin;
use MohamadZatar\Nafath\Enums\NafathLoginStatusEnum;

class NafathService
{
    /**
     * Send login request to Saudi Nafath API.
     *
     * @param string $idNumber
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendLoginRequest($idNumber)
    {
        $url = "https://nafath.api.elm.sa/stg/api/v1/mfa/request?local=ar&requestId={$idNumber}";
        $data = [
            'nationalId' => $idNumber,
            'service' => 'RequestDigitalServicesEnrollment',
        ];

        try {
            $response = Http::withHeaders([
                'APP-KEY' => '17ca15a6d0c60537134e88d4c67c3896',
                'APP-ID' => '1caad583',
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->post($url, $data);
            $statusCode = $response->status();
            $responseBody = $response->json();
            if ($statusCode !== 200) {
                Log::error('NAFATH Error', ['error' => $responseBody['error'] ?? 'Unknown error']);
                return ['error' => $responseBody['error'] ?? 'Unknown error', 'status' => $statusCode];
            }
            Log::info('NAFATH Success', $responseBody);


            return [
                'trans_id' => $responseBody['transId'],
                'random' => $responseBody['random'],
                'status' => 200
            ];
        } catch (\Exception $e) {
            Log::error('Nafath EXCEPTION !!!', [
                'Message' => $e->getMessage(),
                'Line' => $e->getLine(),
                'File' => $e->getFile(),
            ]);
            return ['error' => 'An unexpected error occurred.', 'status' => 500];
        }
    }

    public function handleCallback($response)
    {
        try {
            $decodedToken = $this->decodeJwt($response);
            $responseCollection = collect($decodedToken);

            $trans_id = $responseCollection->get('transId');
            $status = $responseCollection->get('status');

            Log::channel('nafath')->debug('Callback Parameters:', [
                'trans_id' => $trans_id,
                'status' => $status,
            ]);
        } catch (\Exception $e) {
            Log::channel('nafath')->error('Nafath EXCEPTION !!!:', [
                'Message' => $e->getMessage(),
                'Line' => $e->getLine(),
                'File' => $e->getFile(),
            ]);
        }
    }

    /**
     * Decode JWT token.
     *
     * @param string $token
     * @return object
     */
    private function decodeJwt($token)
    {
        $base64UrlEncodedPayload = explode('.', $token)[1];
        $base64UrlDecodedPayload = strtr($base64UrlEncodedPayload, '-_', '+/');
        return json_decode(base64_decode($base64UrlDecodedPayload));
    }
}
