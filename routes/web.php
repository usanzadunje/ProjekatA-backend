<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::view('/', 'index');
Route::get('/projekata/{secret}', function(string $secret) {
    if($secret !== 'opasnasifra') {
        return response('You are not allowed here!', 403);
    }

    return view('projekata.index');
});

Route::any('{any}', function() {
    abort(403);
})->where('any', '.*');