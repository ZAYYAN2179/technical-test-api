<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentWebhookController extends Controller
{
    public function handle(Request $request): JsonResponse
    {
        Log::info(
            hash_hmac(
                'sha256',
                $request->getContent(),
                config('services.payment_webhook.secret')
            )
        );

        // 1. Ambil signature dari header
        $signature = $request->header('X-Signature');

        // 2. Ambil secret
        $secret = config('services.payment_webhook.secret');

        // 3. Validasi signature
        $expectedSignature = hash_hmac(
            'sha256',
            $request->getContent(),
            $secret
        );

        if ($signature !== $expectedSignature) {
            return response()->json([
                'message' => 'Invalid signature'
            ], 401);
        }

        // 4. Ambil data webhook
        $orderCode = $request->input('order_code');
        $status = $request->input('status');

        $order = Order::where('order_code', $orderCode)->first();

        if (! $order) {
            return response()->json([
                'message' => 'Order not found'
            ], 404);
        }

        // 5. Idempotency (ANTI DOUBLE UPDATE)
        if ($order->status === 'paid') {
            return response()->json([
                'message' => 'Order already paid'
            ]);
        }

        // 6. Update status jika PAID
        if ($status === 'PAID') {
            $order->update([
                'status' => 'paid',
                'paid_at' => now(),
            ]);
        }

        return response()->json([
            'message' => 'Webhook processed'
        ]);
    }
}
