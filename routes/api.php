<?php
declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\MockPaymentController;
use App\Http\Controllers\PaymentWebhookController;

Route::post('/webhook/payment', [PaymentWebhookController::class, 'handle']);

Route::post('/mock-payment', [MockPaymentController::class, 'store']);

Route::post('/checkout', [CheckoutController::class, 'store']);

Route::get('/health', function () {
    return response()->json([
        'status' => 'OK'
    ]);
});