<?php declare(strict_types=1);

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarcodeController;
use App\Http\Controllers\MdController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::post('/login', [AuthController::class, 'login'])->name('login')->middleware('guest');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::get('/', [MdController::class, 'top'])->name('top');

Route::get('/gen', fn() => view('gen'));

Route::get('/sitemap.xml', [SitemapController::class, 'index']);

Route::prefix('barcode')->name('barcode.')->group(function() {
    Route::get('/', [BarcodeController::class, 'display'])->name('display');
    Route::get('/scanner', [BarcodeController::class, 'scanner'])->name('scanner');
});

Route::get('/{id}', [MdController::class, 'show'])->name('md.show')->where('id', '[a-f0-9]{32}');
