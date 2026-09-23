<?php

namespace App\Service\Ghasedak;

use Illuminate\Support\Facades\Http;

class smsService
{
    private string $url = 'https://gateway.ghasedak.me/rest/api/v1/webservice/sendsinglesms';

    public function send(
        string $receptor,
        string $message,
        ?string $clientReferenceId = null
    ): array {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'ApiKey' => config('services.ghasedak.api_key'),
        ])->post($this->url, [
            'sendDate' => now()->toIso8601String(),
            'lineNumber' => config('services.ghasedak.line_number'),
            'receptor' => $receptor,
            'message' => $message,
            'clientReferenceId' => $clientReferenceId,
            'socialMediaAttachedFileId' => null,
        ]);

        return [
            'success' => $response->successful(),
            'status' => $response->status(),
            'data' => $response->json(),
            'raw' => $response->body(),
        ];
    }
}
