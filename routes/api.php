<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\OffDayController;
use App\Http\Controllers\API\PlaceController;
use App\Http\Controllers\API\FirebaseController;
use App\Http\Controllers\API\PlaceFavoritesController;
use App\Http\Controllers\API\PlaceSubscriptionController;
use App\Http\Controllers\API\SectionController;
use App\Http\Controllers\API\StaffController;
use App\Http\Controllers\API\TableController;
use App\Http\Controllers\API\ProfileController;
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
    Route::group(['prefix' => 'subscriptions', 'middleware' => 'throttle:subscribe'], function() {
        Route::get('/place', [PlaceSubscriptionController::class, 'index']);
        Route::get('/place/ids', [PlaceSubscriptionController::class, 'subscriptionIds']);
        Route::post(
            '/place/{placeId}/notify-in-next/{notificationTime?}',
            [PlaceSubscriptionController::class, 'store']
        );
        Route::delete('/place/{placeId}', [PlaceSubscriptionController::class, 'destroy']);
    });

    // Place favourites routes
    Route::group(['prefix' => 'favorites'], function() {
        Route::get('/place/ids', [PlaceFavoritesController::class, 'index']);
        Route::post('/place/{place}', [PlaceFavoritesController::class, 'store']);
        Route::delete('/place/{place}', [PlaceFavoritesController::class, 'destroy']);
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
    Route::group(['prefix' => 'staff'], function() {
        Route::get('/', [StaffController::class, 'index']);
        Route::get('/active', [StaffController::class, 'activeIndex']);
        Route::post('', [StaffController::class, 'store']);
        Route::put('/{staff}', [StaffController::class, 'update'])
            ->middleware('can:update,staff');
        Route::delete('/{staff}', [StaffController::class, 'destroy'])
            ->middleware('can:destroy,staff');
    });


    // Place specific routes
    Route::group(['prefix' => 'place'], function() {
        Route::put('/', [PlaceController::class, 'update']);

        // Place images specific routes
        Route::group(['prefix' => 'images'], function() {
            Route::post('/', [ImageController::class, 'storeForPlace']);
            Route::post('/main/{image}', [ImageController::class, 'main'])
                ->middleware('can:manipulatePlaceImages,image');
            Route::post('/logo/{image}', [ImageController::class, 'logo'])
                ->middleware('can:manipulatePlaceImages,image');
            Route::delete('/{image}', [ImageController::class, 'destroy'])
                ->middleware('can:manipulatePlaceImages,image');
        });

        // Tables specific routes
        Route::group(['prefix' => 'tables'], function() {
            Route::post('/', [TableController::class, 'storeOrUpdate']);
            Route::put('/{table}', [TableController::class, 'update'])
                ->middleware('can:update,table');
            Route::delete('/{table}', [TableController::class, 'destroy'])
                ->middleware('can:destroy,table');

            // Table sections specific routes
            Route::group(['prefix' => 'sections'], function() {
                Route::post('/', [SectionController::class, 'store']);
                Route::put('/{section}', [SectionController::class, 'update'])
                    ->middleware('can:update,section');
                Route::delete('/{section}', [SectionController::class, 'destroy'])
                    ->middleware('can:destroy,section');
            });
        });

        // Menu specific routes
        Route::group(['prefix' => 'menu'], function() {
            // Categories specific routes
            Route::group(['prefix' => 'category'], function() {
                Route::get('/place', [CategoryController::class, 'index']);
                Route::get('/{category}', [CategoryController::class, 'show']);
                Route::post('/', [CategoryController::class, 'store']);
                Route::put('/{category}', [CategoryController::class, 'update'])
                    ->middleware('can:update,category');
                Route::delete('/{category}', [CategoryController::class, 'destroy'])
                    ->middleware('can:destroy,category');
            });

            // Products specific routes
            Route::group(['prefix' => 'product'], function() {
                Route::get('/place', [ProductController::class, 'index']);
                Route::get('/{product}', [ProductController::class, 'show']);
                Route::post('/', [ProductController::class, 'store']);
                Route::put('/{product}', [ProductController::class, 'update'])
                    ->middleware('can:update,product');
                Route::delete('/{product}', [ProductController::class, 'destroy'])
                    ->middleware('can:destroy,product');
                Route::post('/{product}/images', [ImageController::class, 'storeForProduct'])
                    ->middleware('can:upload,product');
            });
        });
    });

    Route::group(['prefix' => 'days-off'], function() {
        Route::get('/', [OffDayController::class, 'indexByPlace']);
        Route::put('/{offDay}/approve', [OffDayController::class, 'approve'])
            ->middleware('can:changeStatus,offDay');
        Route::put('/{offDay}/decline', [OffDayController::class, 'decline'])
            ->middleware('can:changeStatus,offDay');
    });

});

// Routes for staff that works in place
Route::group(['prefix' => 'staff', 'middleware' => ['auth:sanctum', 'staff', 'throttle:staff']], function() {
    Route::post('/activity', [StaffController::class, 'toggle']);

    Route::get('/place/tables', [TableController::class, 'index']);

    // Table specific routes
    Route::group(['prefix' => 'table'], function() {
        Route::get('/availability', [PlaceController::class, 'availability']);
        Route::post('/{table}/toggle', [TableController::class, 'toggle'])
            ->middleware('can:toggle,table');
        Route::post('/toggle/{available}', [TableController::class, 'randomToggle']);
    });

    Route::group(['prefix' => 'days-off'], function() {
        Route::get('/', [OffDayController::class, 'index']);
        Route::post('/', [OffDayController::class, 'store']);
    });

});
