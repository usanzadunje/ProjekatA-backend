<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\PlaceController;
use App\Http\Controllers\API\FirebaseController;
use App\Http\Controllers\API\PlaceSubscriptionController;
use App\Http\Controllers\API\StaffController;
use App\Http\Controllers\API\TableController;
use App\Http\Controllers\API\ProfileController;
use App\Http\Controllers\GithubWebhooksController;
use App\Http\Controllers\API\ImageController;
use App\Http\Controllers\API\ProductController;
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
    Route::delete('/fcm-token', [FirebaseController::class, 'destroy'])->middleware(['auth:sanctum']);
});


// User routes
Route::group(['prefix' => 'user', 'middleware' => 'auth:sanctum'], function() {
    // User specific routes
    Route::put('/profile-information', [ProfileController::class, 'update'])->middleware('throttle:update');


    // Place subscription routes
    Route::group(['middleware' => 'throttle:subscribe'], function() {
        Route::get('/subscriptions/place', [PlaceSubscriptionController::class, 'index']);
        Route::get('/subscriptions/place/ids', [PlaceSubscriptionController::class, 'subscriptionIds']);
        Route::post(
            '/subscriptions/place/{placeId}/notify-in-next/{notificationTime?}',
            [PlaceSubscriptionController::class, 'store']
        );
        Route::delete('/subscriptions/place/{placeId}', [PlaceSubscriptionController::class, 'destroy']);
    });
});

//Routes for places
Route::group(['prefix' => 'places', 'middleware' => 'throttle:places'], function() {
    Route::get('/', [PlaceController::class, 'index']);
    Route::get('/{placeId}', [PlaceController::class, 'show'])->name('place.show');
    Route::get('/{place}/images', [PlaceController::class, 'images']);
    Route::get('/{place}/category/{category}/products', [ProductController::class, 'index']);
    Route::get('/product/{product}/images', [ProductController::class, 'images']);
    Route::get('/{place}/working-hours', [PlaceController::class, 'workingHours']);
    Route::get('/{placeId}/tables', [TableController::class, 'index']);
});

// Routes for owner of the place
Route::group(['prefix' => 'owner', 'middleware' => ['auth:sanctum', 'owner', 'throttle:owner']], function() {
    // Staff specific router
    Route::get('/staff', [StaffController::class, 'index']);
    Route::post('/staff', [StaffController::class, 'store']);
    Route::put('/staff/{staff}', [StaffController::class, 'update'])
        ->middleware('can:update,staff');
    Route::delete('/staff/{staff}', [StaffController::class, 'destroy'])
        ->middleware('can:destroy,staff');

    // Place specific routes
    Route::put('/place', [PlaceController::class, 'update']);
    Route::post('/place/images', [ImageController::class, 'storeForPlace']);
    Route::post('/place/images/main/{image}', [ImageController::class, 'main'])
        ->middleware('can:manipulatePlaceImages,image');
    Route::post('/place/images/logo/{image}', [ImageController::class, 'logo'])
        ->middleware('can:manipulatePlaceImages,image');
    Route::delete('/place/images/{image}', [ImageController::class, 'destroy'])
        ->middleware('can:manipulatePlaceImages,image');

    // Tables specific routes
    Route::post('/place/tables', [TableController::class, 'storeOrUpdate']);
    Route::put('/place/tables/{table}', [TableController::class, 'update'])
        ->middleware('can:update,table');
    Route::delete('/place/tables/{table}', [TableController::class, 'destroy'])
        ->middleware('can:destroy,table');

    // Categories specific routes
    Route::get('/menu/category/place/', [CategoryController::class, 'index']);
    Route::get('/menu/category/{category}', [CategoryController::class, 'show']);
    Route::post('/menu/category', [CategoryController::class, 'create']);
    Route::put('/menu/category/{category}', [CategoryController::class, 'update'])
        ->middleware('can:update,category');
    Route::delete('/menu/category/{category}', [CategoryController::class, 'destroy'])
        ->middleware('can:destroy,category');

    // Products specific routes
    Route::get('/menu/product/place/', [ProductController::class, 'index']);
    Route::get('/menu/product/{product}', [ProductController::class, 'show']);
    Route::post('/menu/product', [ProductController::class, 'create']);
    Route::put('/menu/product/{product}', [ProductController::class, 'update'])
        ->middleware('can:update,product');
    Route::delete('/menu/product/{product}', [ProductController::class, 'destroy'])
        ->middleware('can:destroy,product');
    Route::post('/product/{product}/images', [ImageController::class, 'storeForProduct'])
        ->middleware('can:upload,product');
});

// Routes for staff that works in place
Route::group(['prefix' => 'staff', 'middleware' => ['auth:sanctum', 'staff', 'throttle:staff']], function() {
    Route::post('/activity', [StaffController::class, 'toggle']);
    Route::get('/place/tables', [TableController::class, 'index']);
    Route::get('/table/availability', [PlaceController::class, 'availability']);
    Route::post('/table/{table}/toggle', [TableController::class, 'toggle'])
        ->middleware('can:toggle,table');
    Route::post('/table/toggle/{available}', [TableController::class, 'randomToggle']);
});
