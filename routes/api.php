<?php

use App\Api\v1\Controllers\ServerInfoController;
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
Route::get('ping', [ServerStatController::class, 'ping'])
    ->name('ping');

Route::prefix('setup')->name('setup.')->group(function () {
    Route::post('api_key', [SetupController::class, 'setupApiKey'])
        ->name('api_key');
    Route::post('server_key', [SetupController::class, 'setupServerKey'])
        ->name('server_key');
});

Route::middleware('api_access')
    ->name('v1.')
    ->prefix('v1')
    ->group(function () {
        Route::post('servers', [ServerInfoController::class, 'info'])
            ->name('info');

        Route::post('block-info', [ServerStatController::class, 'blockInfo'])
            ->name('block-info');
        Route::post('server-stats', [ServerStatController::class, 'serverStats'])
            ->name('server-stats');
    });
