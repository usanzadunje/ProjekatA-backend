<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\PlaceController;
use App\Http\Controllers\API\FirebaseController;
use App\Http\Controllers\API\PlaceSubscriptionController;
use App\Http\Controllers\API\StaffController;
use App\Http\Controllers\API\TableController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\GithubWebhooksController;
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

// Github webhooks
//Route::post('/deploy', [GithubWebhooksController::class, 'deploy']);


// Authentication routes
Route::get('/auth/user', AuthController::class)->middleware(['auth:sanctum', 'throttle:default']);
Route::group(['middleware' => 'throttle:auth'], function() {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/callback', [AuthController::class, 'social']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware(['auth:sanctum']);
});

// Routes for Firebase stuff
Route::group(['middleware' => 'throttle:fcm'], function() {
    Route::post('/fcm-token', [FirebaseController::class, 'store'])->middleware(['auth:sanctum']);
    Route::post('/fcm-token/remove', [FirebaseController::class, 'destroy'])->middleware(['auth:sanctum']);
});


// User routes
Route::group(['prefix' => 'user', 'middleware' => 'auth:sanctum'], function() {
    // User specific routes
    Route::put('/profile-information', [UserController::class, 'update'])->middleware('throttle:update');


    // Place subscription routes
    Route::group(['middleware' => 'throttle:subscribe'], function() {
        Route::get('/cafes/subscriptions', [PlaceSubscriptionController::class, 'index']);
        Route::post('/subscribe/cafe/{cafeId}/notify-in-next/{notificationTime?}', [PlaceSubscriptionController::class, 'store']);
        Route::post('/subscribed/cafe/{cafeId}', [PlaceSubscriptionController::class, 'show']);
        Route::post('/unsubscribe/cafe/{cafeId}', [PlaceSubscriptionController::class, 'destroy']);
    });
});

//Routes for cafes
Route::group(['prefix' => 'cafes', 'middleware' => 'throttle:places'], function() {
    Route::get('/chunked/start/number-of-cafes/{start?}/{numberOfCafes?}', [PlaceController::class, 'index'])
        ->name('cafes/chunked');
    Route::get('/{cafe}', [PlaceController::class, 'show'])->name('cafes/show');
    Route::get('/{place}/images', [PlaceController::class, 'images']);
    Route::get('/{place}/working-hours', [PlaceController::class, 'workingHours']);
    Route::get('/{placeId}/tables', [TableController::class, 'index']);
});

// Routes for owner of the place
Route::group(['prefix' => 'owner', 'middleware' => ['auth:sanctum', 'owner', 'throttle:owner']], function() {
    // Staff specific router
    Route::get('/staff', [StaffController::class, 'index']);
    Route::post('/staff', [StaffController::class, 'store']);
    Route::put('/staff/{staff}', [StaffController::class, 'update'])->middleware('can:edit,staff');
    Route::delete('/staff/{staff}', [StaffController::class, 'destroy'])->middleware('can:delete,staff');

    // Place specific routes
    Route::put('/place-information', [PlaceController::class, 'update']);
    Route::post('/place/images/upload', [PlaceController::class, 'imageUpload']);
    Route::post('/place/images/set-main/{image}', [PlaceController::class, 'imageSetMain']);
    Route::post('/place/images/remove/{image}', [PlaceController::class, 'imageDestroy']);

    // Tables specific routes
    Route::get('/place/tables', [TableController::class, 'index']);
    Route::post('/place/tables', [TableController::class, 'storeOrUpdate']);
});

// Routes for staff that works in place
Route::group(['prefix' => 'staff', 'middleware' => ['auth:sanctum', 'staff', 'throttle:staff']], function() {
    Route::post('/activity', [StaffController::class, 'toggle']);
    Route::get('/table/availability', [PlaceController::class, 'availability']);
    //Route::post('/table/{table}/toggle', [TableController::class, 'toggle'])->middleware('can:toggle,table');
    Route::post('/table/toggle/{available}', [TableController::class, 'toggle']);
});

/*
 *
 * ODAVCE NA DOLE TREBA DA SE DORADE STVARI
 *
 * */
//Route for tables in certain cafe
Route::group(['prefix' => 'cafe', 'middleware' => 'throttle:tables'], function() {
    //Route::get('/{cafe}/tables', [TableController::class, 'index']);
    //Route::get('/{cafe}/tables/{serialNumber}', [TableController::class, 'show']);
});

//Route for changing availability of tables in a certain cafe
