<?php
declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CheckoutController;

Route::post('/checkout', [CheckoutController::class, 'store']);

Route::get('/health', function () {
    return response()->json([
        'status' => 'OK'
    ]);
});