<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MockPaymentController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'order_code' => ['required', 'string'],
            'amount' => ['required', 'integer'],
        ]);

        return response()->json([
            'order_code' => $request->order_code,
            'amount' => $request->amount,
            'payment_url' => 'https://fake-payment.test/pay/' . $request->order_code,
        ]);
    }
}