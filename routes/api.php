<?php

use App\Api\v1\Controllers\ServerController;
use App\Api\v1\Controllers\ServerStatController;
use App\Api\v1\Controllers\SetupController;
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
Route::get('/', [ServerStatController::class, 'index'])
    ->name('home');

Route::get('ping', [ServerStatController::class, 'ping'])
    ->name('ping');

Route::prefix('setup')->name('setup.')->group(function () {
    Route::post('api_key', [SetupController::class, 'setupApiKey'])
        ->name('setup.api_key');
});

/** routes require x-api-key header */
Route::middleware('api_access')
    ->name('v1.')
    ->prefix('v1')
    ->group(function () {
        Route::post('node-info', [ServerStatController::class, 'nodeInfo'])
            ->name('post.node-info');

        Route::post('server-stats', [ServerStatController::class, 'storeServerStats'])
            ->name('post.server-stats');
        Route::get('server-stats', [ServerStatController::class, 'getServerStats'])
            ->name('get.server-stats');

    });
