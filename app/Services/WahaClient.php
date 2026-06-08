<?php

namespace App\Services;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class WahaClient
{
    public function __construct(
        protected WhatsAppLinkService $whatsAppLinkService,
    ) {
    }

    public function sendText(?string $number, string $message): bool
    {
        $chatId = $this->chatId($number);

        if ($chatId === null || trim($message) === '') {
            return false;
        }

        $response = $this->request()->post($this->endpoint('/api/sendText'), [
            'session' => config('services.waha.session', 'default'),
            'chatId' => $chatId,
            'text' => $message,
        ]);

        return $response->successful();
    }

    public function chatId(?string $number): ?string
    {
        if ($number === null || trim($number) === '') {
            return null;
        }

        if (Str::contains($number, '@')) {
            return $number;
        }

        $normalized = $this->whatsAppLinkService->normalize($number);

        return $normalized ? $normalized . '@c.us' : null;
    }

    protected function request(): PendingRequest
    {
        $request = Http::acceptJson()
            ->asJson()
            ->timeout((int) config('services.waha.timeout', 10));

        if ($apiKey = config('services.waha.api_key')) {
            $request = $request->withHeaders([
                'X-Api-Key' => $apiKey,
            ]);
        }

        return $request;
    }

    protected function endpoint(string $path): string
    {
        return rtrim((string) config('services.waha.base_url', 'http://localhost:3000'), '/') . $path;
    }
}
