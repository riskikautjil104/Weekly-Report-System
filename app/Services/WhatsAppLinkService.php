<?php

namespace App\Services;

class WhatsAppLinkService
{
    public function build(?string $number, string $message = ''): ?string
    {
        $normalized = $this->normalize($number);

        if ($normalized === null) {
            return null;
        }

        $url = 'https://wa.me/' . $normalized;

        if ($message !== '') {
            $url .= '?text=' . rawurlencode($message);
        }

        return $url;
    }

    public function normalize(?string $number): ?string
    {
        $digits = preg_replace('/\D+/', '', (string) $number) ?: '';

        if ($digits === '') {
            return null;
        }

        if (str_starts_with($digits, '0')) {
            $digits = '62' . substr($digits, 1);
        }

        return $digits;
    }
}
