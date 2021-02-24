<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CafeController;
use App\Http\Controllers\TableController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:sanctum'])->group(function() {
    Route::get('/users/auth', AuthController::class);
});

Route::prefix('cafes')->group(function() {
    Route::get('/', [CafeController::class, 'index']);
    Route::get('/{cafe}', [CafeController::class, 'show']);
});

Route::prefix('cafe')->group(function() {
    Route::get('/{cafe}/tables', [TableController::class, 'index']);
    Route::get('/{cafe}/tables/{serialNumber}', [TableController::class, 'show']);
});

