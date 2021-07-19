<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CafeController;
use App\Http\Controllers\API\SocialAuthController;
use App\Http\Controllers\API\StaffController;
use App\Http\Controllers\API\TableController;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\DB;
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


Route::get('/test/{lat}/{lng}', function($lat, $lng) {

});


Route::get('/auth/user', AuthController::class)->middleware(['auth:sanctum']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware(['auth:sanctum']);
Route::post('/callback', [SocialAuthController::class, 'providerResponse']);
Route::post('/fcm-token', [AuthController::class, 'setFcmToken'])->middleware(['auth:sanctum']);
Route::post('/fcm-token/remove', [AuthController::class, 'removeFcmToken'])->middleware(['auth:sanctum']);


// Authentication routes
Route::prefix('users')->middleware(['auth:sanctum'])->group(function() {
    Route::post('/subscribe/cafe/{cafeId}/notify-in-next/{notificationTime?}', [CafeController::class, 'subscribe']);
    Route::post('/unsubscribe/cafe/{cafeId}', [CafeController::class, 'unsubscribe']);
    Route::post('/subscribed/cafe/{cafeId}', [CafeController::class, 'isUserSubscribed']);
    Route::get('/cafes/subscriptions', [CafeController::class, 'getAllCafesUserSubscribedTo']);
});

//Routes for cafes
Route::prefix('cafes')->group(function() {
    Route::get('/', [CafeController::class, 'index'])->name('cafes/index');
    Route::get('/chunked/start/number-of-cafes/{start?}/{numberOfCafes?}', [CafeController::class, 'chunkedIndex'])
        ->name('cafes/chunked');
    Route::get('/{cafe}', [CafeController::class, 'show'])->name('cafes/show');
});

//Route for tables in certain cafe
Route::prefix('cafe')->group(function() {
    Route::get('/{cafe}/tables', [TableController::class, 'index']);
    Route::get('/{cafe}/tables/{serialNumber}', [TableController::class, 'show']);
});

//Route for changing availability of tables in a certain cafe
Route::prefix('staff')->middleware('staff')->group(function() {
});
Route::post('/staff/tables/{table}/toggle', [StaffController::class, 'toggleAvailability']);
