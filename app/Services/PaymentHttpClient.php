<?php
declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PaymentHttpClient
{
    public function createPayment(string $orderCode, int $amount): array
    {
        $response = Http::retry(3, 200)
            ->timeout(5)
            ->post(config('services.payment.url') . '/api/mock-payment', [
                'order_code' => $orderCode,
                'amount' => $amount,
            ]);

        if ($response->failed()) {
            throw new \Exception('Payment gateway error');
        }

        return $response->json();
    }
}