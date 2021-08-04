<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CafeController;
use App\Http\Controllers\API\FirebaseController;
use App\Http\Controllers\API\PlaceSubscriptionController;
use App\Http\Controllers\API\StaffController;
use App\Http\Controllers\API\TableController;
use App\Http\Controllers\API\UserController;
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

//Broadcast::routes(['middleware' => ['auth:sanctum']]);

// Authentication routes
Route::get('/auth/user', AuthController::class)->middleware(['auth:sanctum']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/callback', [AuthController::class, 'social']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware(['auth:sanctum']);

// Routes for Firebase stuff
Route::post('/fcm-token', [FirebaseController::class, 'setFcmToken'])->middleware(['auth:sanctum']);
Route::post('/fcm-token/remove', [FirebaseController::class, 'removeFcmToken'])->middleware(['auth:sanctum']);


// User routes routes
Route::prefix('user')->middleware(['auth:sanctum'])->group(function() {
    // User specific routes
    Route::post('/profile-information', [UserController::class, 'update']);


    // Place subscription routes
    Route::post('/subscribe/cafe/{cafeId}/notify-in-next/{notificationTime?}', [PlaceSubscriptionController::class, 'subscribe']);
    Route::post('/unsubscribe/cafe/{cafeId}', [PlaceSubscriptionController::class, 'unsubscribe']);
    Route::post('/subscribed/cafe/{cafeId}', [PlaceSubscriptionController::class, 'isUserSubscribed']);
    Route::get('/cafes/subscriptions', [PlaceSubscriptionController::class, 'subscriptions']);
});

//Routes for cafes
Route::prefix('cafes')->group(function() {
    Route::get('/', [CafeController::class, 'index'])->name('cafes/index');
    Route::get('/chunked/start/number-of-cafes/{start?}/{numberOfCafes?}', [CafeController::class, 'index'])
        ->name('cafes/chunked');
    Route::get('/{cafe}', [CafeController::class, 'show'])->name('cafes/show');
});

/*
 *
 * ODAVCE NA DOLE TREBA DA SE DORADE STVARI
 *
 * */


//Route for tables in certain cafe
Route::prefix('cafe')->group(function() {
    Route::get('/{cafe}/tables', [TableController::class, 'index']);
    Route::get('/{cafe}/tables/{serialNumber}', [TableController::class, 'show']);
});

//Route for changing availability of tables in a certain cafe
Route::prefix('staff')->middleware('staff')->group(function() {
});
Route::post('/staff/tables/{table}/toggle', [StaffController::class, 'toggleAvailability']);
