<?php

namespace App\Api\v1\Controllers;

use App\Api\v1\Requests\ApiHealthRequest;
use App\Models\ServerStat;
use App\Service\ApiKeyService;
use App\Service\ConnectionChecker;
use Illuminate\Http\JsonResponse;

class SetupController
{
    const DEFAULT_CHECK_PERIOD = 30;

    /**
     * @hideFromAPIDocumentation
     * @codeCoverageIgnore
     */
    public function index(): void
    {
        return;
    }

    /**
     * Get an API Key
     *
     * create a new API key.
     * <aside class="warning">Throttle: 1 request every 60 sec.</aside>
     * @group    Setup
     * @response scenario=Success {"message": "API key generated", "api_key": "c7654335-3e00-41ee-a879-3011c5399d89"}
     * @unauthenticated
     */
    public function setupApiKey(ApiKeyService $apiKeyService): JsonResponse
    {
        return response()->json([
            'message' => 'API key generated',
            'api_key' => $apiKeyService->generateKey(),
        ], JsonResponse::HTTP_OK);
    }

    /**
     * Ping
     *
     * Test the availability of this API.
     * @unauthenticated
     * @group Setup
     */
    public function ping(): JsonResponse
    {
        return response()->json([
            'message'     => 'pong',
            'server_time' => now(),
        ], JsonResponse::HTTP_OK);
    }

    /**
     * API Health Check
     *
     * To check the availability of the API, you can setup a ping to this endpoint. It throws a HTTP 500 if a system
     * is not running well - otherwise it's a HTTP 200.
     * @unauthenticated
     * @group         Setup
     * @responseField redis_connection boolean Check if the redis system is available.
     * @responseField database_connection boolean Check if the database is available.
     * @responseField new_data_in_period boolean Check if new data was pushed to the API in the last 30min.
     * @queryParam    period integer Check the new data in the given period in minutes (min: 10). Default: 30
     * Example: 30
     * @responseField server_time string Current server time
     * @response      scenario=Success
     *                {"redis_connection":true,"database_connection":true,"new_data_in_period":true,"server_time":"2021-09-06T15:46:24.731762Z"}
     * @response      status=500 scenario=Error {"redis_connection":false,"database_connection":true,
     * "new_data_in_period":true,
     * "server_time":"2021-09-06T15:46:24.731762Z"}
     */
    public function health(ApiHealthRequest $request, ConnectionChecker $connectionChecker): JsonResponse
    {
        $data = [
            'redis_connection'    => $connectionChecker::isRedisReady(),
            'database_connection' => $connectionChecker::isDatabaseReady(),
            'new_data_in_period'  => ServerStat::where('created_at', '>',
                    now()->subMinutes($request->input('period', self::DEFAULT_CHECK_PERIOD)))
                    ->count() > 0,
            'server_time'         => now(),
        ];

        return response()->json(
            $data,
            in_array(false, $data)
                ? JsonResponse::HTTP_INTERNAL_SERVER_ERROR
                : JsonResponse::HTTP_OK
        );
    }
}
