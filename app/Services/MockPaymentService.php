<?php
declare(strict_types=1);

namespace App\Services;

class MockPaymentService
{
    public function create(string $orderCode, int $amount): array
    {
        return [
            'order_code' => $orderCode,
            'amount' => $amount,
            'payment_url' => 'https://fake-payment.test/pay/' . $orderCode,
        ];
    }
}