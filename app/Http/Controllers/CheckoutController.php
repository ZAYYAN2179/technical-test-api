<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\PaymentHttpClient;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function store(Request $request, PaymentHttpClient $paymentClient): JsonResponse
    {
        $request->validate([
            'amount' => ['required', 'integer', 'min:1000'],
        ]);

        $order = Order::create([
            'order_code' => 'ORD-' . Str::uuid(),
            'amount' => $request->amount,
            'status' => 'pending',
        ]);

        $payment = $paymentClient->createPayment(
            $order->order_code,
            $order->amount
        );

        return response()->json([
            'message' => 'Checkout created',
            'data' => [
                'order_code' => $order->order_code,
                'payment_url' => $payment['payment_url'],
            ]
        ], 201);
    }
}