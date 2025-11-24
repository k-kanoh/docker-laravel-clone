<?php declare(strict_types=1);

use App\Http\Controllers\Api\BarcodeController;
use App\Http\Controllers\Api\FavoriteController;
use App\Http\Controllers\Api\GenListenersSummaryController;
use App\Http\Controllers\Api\NowPlayingController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::apiResource('gen', NowPlayingController::class, ['only' => ['index']]);

Route::apiResource('listeners', GenListenersSummaryController::class, ['only' => ['index']]);

Route::middleware('auth:sanctum')->group(function() {
    Route::apiResource('favorite', FavoriteController::class, ['only' => ['store', 'destroy']])->whereNumber('favorite');
});

Route::prefix('barcode')->group(function() {
    Route::post('create', [BarcodeController::class, 'createSession'])->middleware('throttle:100,1');
    Route::post('scan/{sessionId}', [BarcodeController::class, 'scan'])->middleware('throttle:30,1');
    Route::post('clear/{sessionId}', [BarcodeController::class, 'clear'])->middleware('throttle:30,1');
    Route::get('poll/{sessionId}', [BarcodeController::class, 'poll'])->middleware('throttle:60,1');
});
