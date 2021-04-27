<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CafeController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\TableController;
use Illuminate\Support\Facades\Broadcast;
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

Broadcast::routes(['middleware' => ['auth:sanctum']]);

// Authentication routes
Route::prefix('users')->middleware(['auth:sanctum'])->group(function() {
    Route::get('/auth', AuthController::class);
    Route::post('/fcm-token', [AuthController::class, 'setFcmToken']);
    Route::post('/fcm-token/remove', [AuthController::class, 'removeFcmToken']);
    Route::post('/subscribe/cafe/{cafeId}/notify-in-next/{notificationTime?}', [CafeController::class, 'subscribe'])
        ->where(['cafeId' => '[0-9]+', 'notificationTime' => '[0-9]+']);
    Route::post('/unsubscribe/cafe/{cafeId}', [CafeController::class, 'unsubscribe'])
        ->where(['cafeId' => '[0-9]+']);
    Route::post('/subscribed/cafe/{cafeId}', [CafeController::class, 'isUserSubscribed'])
        ->where(['cafeId' => '[0-9]+']);
    Route::get('/cafes/subscriptions', [CafeController::class, 'getAllCafesUserSubscribedTo']);
});

//Routes for cafes
Route::prefix('cafes')->group(function() {
    Route::get('/', [CafeController::class, 'index'])->name('cafes/index');
    Route::get('/chunked/start/number-of-cafes/{start?}/{numberOfCafes?}', [CafeController::class, 'chunkedIndex'])
        ->where(['start' => '[0-9]+', 'numberOfCafes' => '[0-9]+'])->name('cafes/chunked');
    Route::get('/{cafe}', [CafeController::class, 'show'])->name('cafes/show');
});

//Route for tables in certain cafe
Route::prefix('cafe')->group(function() {
    Route::get('/{cafe}/tables', [TableController::class, 'index']);
    Route::get('/{cafe}/tables/{serialNumber}', [TableController::class, 'show']);
});

//Route for changing availability of tables in a certain cafe
Route::prefix('staff')->middleware('staff')->group(function() {
    Route::post('/tables/{table}/toggle', [StaffController::class, 'toggleAvailability']);
});

