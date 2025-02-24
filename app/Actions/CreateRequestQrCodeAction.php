<?php

namespace App\Actions;

use App\Models\RequestQrCode;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\File;
use App\Models\RetreatRequest;

class CreateRequestQrCodeAction
{
    public function execute(RetreatRequest $retreatRequest): string
    {
        // Prepare the data for the QR code
        $data = [
            'id' => $retreatRequest->id,
            'status' => $retreatRequest->status,
            'user_id' => $retreatRequest->user_id,
            'created_at' => $retreatRequest->created_at->toDateTimeString(),
        ];

        $jsonData = json_encode($data, JSON_THROW_ON_ERROR);

        // Define the directory and file name for saving the QR code
        $directory = public_path('qrcodes');
        $fileName = 'request_' . $retreatRequest->id . time() . '.svg';
        $filePath = $directory . '/' . $fileName;

        // Ensure the directory exists
        File::ensureDirectoryExists($directory);

        // Generate the QR code and save it to the specified path
        try {
            QrCode::format('svg')->size(300)->generate($jsonData, $filePath);
        } catch (\Exception $e) {
            // Handle QR code generation failure
            throw new \RuntimeException('Failed to generate QR code: ' . $e->getMessage());
        }
        if (env('WHERE_AM_I') != 'local') {
            $url = url('public/qrcodes/' . $fileName);
        } else {
            $url = url('qrcodes/' . $fileName);
        }
        $qrCode = $retreatRequest->requestQrCode;

        if ($qrCode) {
            $qrCode->update([
                'qr_code' => $url,
            ]);
        } else {
            $retreatRequest->requestQrCode()->create([
                'qr_code' => $url,
            ]);
        }


        // Return the URL to the QR code
        return $url;
    }
}
