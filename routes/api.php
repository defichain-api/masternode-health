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
    Route::post('server_key', [SetupController::class, 'setupServerKey'])
        ->name('setup.server_key');
});

/** routes require x-api-key header */
Route::middleware('api_access')
    ->group(function () {
        Route::get('servers', [ServerController::class, 'listServers'])
            ->name('v1.server.list')
            ->prefix('v1');
    });

/** routes require x-api-key & x-server-key header */
Route::middleware('api_server_access')
    ->name('v1.')
    ->prefix('v1')
    ->group(function () {
        Route::post('server/rename', [ServerController::class, 'renameServer'])
            ->name('server.rename');
        Route::delete('server/delete', [ServerController::class, 'deleteServer'])
            ->name('server.delete');

        Route::post('node-info', [ServerStatController::class, 'nodeInfo'])
            ->name('node-info');
        Route::post('server-stats', [ServerStatController::class, 'serverStats'])
            ->name('server-stats');
    });
