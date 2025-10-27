<?php declare(strict_types=1);

use App\Http\Controllers\Api\NowPlayingController;
use App\Http\Controllers\UserController;
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

Route::group(['middleware' => 'auth:sanctum'], function() {
    Route::apiResource('gen', NowPlayingController::class);
});

Route::post('login', [UserController::class, 'index']);
