<?php declare(strict_types=1);

use App\Http\Controllers\MdController;
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

Route::get('/', [MdController::class, 'top'])->name('top');

Route::get('/gen', fn() => view('gen'));

Route::get('/barcode', fn() => view('barcode'));

Route::get('/{id}', [MdController::class, 'show'])->name('md.show')->where('id', '[a-f0-9]{32}');
