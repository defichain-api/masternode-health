<?php

use App\Api\v1\Controllers\ServerStatController;
use App\Api\v1\Controllers\SetupController;
use App\Api\v1\Controllers\DataStatusController;
use App\Api\v1\Controllers\StatisticController;
use App\Api\v1\Controllers\WebhookController;
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
Route::get('/', [SetupController::class, 'index'])
    ->name('home');

Route::get('ping', [SetupController::class, 'ping'])
    ->name('ping');
Route::get('health', [SetupController::class, 'health'])
    ->name('health');

Route::get('setup/api_key', [SetupController::class, 'setupApiKey'])
    ->name('setup.api_key')
    ->middleware('api_throttle:1,60');

/** routes require x-api-key header */
Route::middleware('api_access')
    ->name('v1.')
    ->prefix('v1')
    ->group(function () {
        Route::post('node-info', [ServerStatController::class, 'storeNodeInfo'])
            ->name('post.node-info')
            ->middleware('api_throttle:1,300');
        Route::get('node-info', [ServerStatController::class, 'getNodeInfo'])
            ->name('get.node-info')
            ->middleware('api_throttle:60,60');

        Route::post('server-stats', [ServerStatController::class, 'storeServerStats'])
            ->name('post.server-stats')
            ->middleware('api_throttle:1,300');
        Route::get('server-stats', [ServerStatController::class, 'getServerStats'])
            ->name('get.server-stats')
            ->middleware('api_throttle:60,60');

        Route::get('data-status', [DataStatusController::class, 'getDataStatus'])
            ->name('get.data-status')
            ->middleware('api_throttle:60,60');

        Route::prefix('webhook')->name('webhook.')->group(function () {
            Route::post('/', [WebhookController::class, 'create'])->name('create');
            Route::delete('/', [WebhookController::class, 'delete'])->name('delete');
        });
    });

Route::name('statistic.')
    ->prefix('statistic')
    ->group(function () {
        Route::get('all', [StatisticController::class, 'getAll'])
            ->name('all');
        Route::get('last_week', [StatisticController::class, 'getLastWeek'])
            ->name('last_week');
    });
