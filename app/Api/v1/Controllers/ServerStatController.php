<?php

namespace App\Api\v1\Controllers;

use App\Api\v1\Resources\ServerStatCollection;
use App\Api\v1\Requests\NodeInfoRequest;
use App\Api\v1\Requests\ServerStatsRequest;
use App\Enum\Cooldown;
use App\Models\ServerStat;
use App\Repository\ServerStatRepository;
use App\Service\ConnectionChecker;
use App\Service\NodeInfoService;
use App\Service\ServerStatService;
use App\Service\WebhookService;
use Illuminate\Http\JsonResponse;

class ServerStatController
{
    const DEFAULT_CHECK_PERIOD = 30;

    /**
     * @hideFromAPIDocumentation
     */
    public function index(): void
    {
        return;
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
     *                {"redis_connection":true,"database_connection":true,"new_data_last_30min":true,"server_time":"2021-09-06T15:46:24.731762Z"}
     * @response      status=500 scenario=Error {"redis_connection":false,"database_connection":true,
     * "new_data_last_30min":true,
     * "server_time":"2021-09-06T15:46:24.731762Z"}
     */
    public function health(ConnectionChecker $connectionChecker): JsonResponse
    {
        $requestedPeriod = request('period');
        $periodInMinutes = is_numeric($requestedPeriod) && (int)$requestedPeriod >= 10
            ? (int)$requestedPeriod
            : self::DEFAULT_CHECK_PERIOD;

        $data = [
            'redis_connection'    => $connectionChecker::isRedisReady(),
            'database_connection' => $connectionChecker::isDatabaseReady(),
            'new_data_in_period'  => ServerStat::where('created_at', '>',
                    now()->subMinutes($periodInMinutes))->count() > 0,
            'server_time'         => now(),
        ];

        return response()->json(
            $data,
            in_array(false, $data)
                ? JsonResponse::HTTP_INTERNAL_SERVER_ERROR
                : JsonResponse::HTTP_OK
        );
    }

    /**
     * Fullnode Info
     *
     * This endpoint collects information from your running fullnode.
     * <aside class="notice">You don't need to implement this endpoint. It's used by the server script and
     * documented here for a transparent look inside this tool.</aside>
     * <aside class="warning">Throttle: 1 request every 300 sec.</aside>
     * @bodyParam block_height_local integer required The number of the current block. Example: 1131998
     * @bodyParam local_hash string required Hash for the current block. Required length of 64 chars. Example:
     * cefe56ff49a94787a8e8c65da5c4ead6e748838ece6721a06624de15875395a3
     * @bodyParam node_uptime integer required Uptime of the fullnode in seconds. Example: 1343121
     * @bodyParam node_version string required DeFiChain Node Version. Example: 1.6.3
     * @bodyParam connection_count integer Count of the current fullnode connections. Example: 91
     * @bodyParam logsize float Size of the debug.log file in MB. Example: 13.21
     * @bodyParam config_checksum string MD5 Hash of the defi.conf file. Example: a3cca2b2aa1e3b5b3b5aad99a8529074
     * @bodyParam operator_status object[] required Online/Offline information for all masternodes registered on the
     * fullnode. Example: {"id":"cb09568143d7bae6822a7a78f91cb907c23fd12dcf986d4d2c8de89457edf87","online": false}
     * @bodyParam operator_status[].id string required Masternode ID Example:
     * 8cb09568143d7bae6822a7a78f91cb907c23fd12dcf986d4d2c8de89457edf87
     * @bodyParam operator_status[].online bool required
     * @group     Server-Script
     * @response  scenario=Success {"message":"ok"}
     * @authenticated
     */
    public function storeNodeInfo(NodeInfoRequest $request, NodeInfoService $service): JsonResponse
    {
        $service->store($request);

        // @todo implement an analysation of the data
        $apiKey = $request->get('api_key');
        if ($apiKey->webhook && $apiKey->cooldown(Cooldown::WEBHOOK_NODE_INFO)->passed()) {
            app(WebhookService::class)->sendWebhook($apiKey, false, true);
            $apiKey->cooldown(Cooldown::WEBHOOK_NODE_INFO)->until(now()->addMinutes(Cooldown::COOLDOWN_MIN[Cooldown::WEBHOOK_NODE_INFO]));
        }

        return response()->json([
            'message' => 'ok',
        ], JsonResponse::HTTP_OK);
    }

    /**
     * Fullnode Info
     *
     * Pull the latest fullnode info posted to the health API by your server.
     * @group         Pull Information
     * @response      scenario=Success
     *           {"data":[{"type":"config_checksum","value":"a3cca2b2aa1e3b5b3b5aad99a8529074"},{"type":"operator_status","value":[{"id":"8cb09568143d7bae6822a7a78f91cb907c23fd12dcf986d4d2c8de89457edf87","online":true},{"id":"2ceb7c9c3bea0bd0e5e4199eca5d0b797d79a0077a9108951faecf715e1e1a57","online":true}]},{"type":"node_uptime","value":261124},{"type":"local_hash","value":"0d82efc6638c91279e5f493053075226619080515d2f9b583f8cfc42a4f08885"},{"type":"block_height_local","value":1132261},{"type":"connection_count","value":91},{"type":"logsize","value":13.21},{"type":"node_version","value":"1.6.3"}],"latest_update":"2021-08-31T14:14:12.000000Z"}
     * @responseField block_height_local integer Local Block height
     * @responseField operator_status object Lists the masternode id and it's online status
     * @responseField node_uptime integer Uptime of the node in seconds
     * @responseField node_version string Current version of the node
     * @responseField config_checksum string MD5 hash of the defi.conf file
     * @responseField local_hash string block hash of the current block
     * @responseField connection_count integer Number of current connections to the node
     * @responseField logsize numeric Size of the debug.log in MB
     */
    public function getNodeInfo(ServerStatRepository $repository): ServerStatCollection
    {
        return new ServerStatCollection($repository->getLatestNodeInfoForApiKey(request('api_key')));
    }

    /**
     * Server Stats
     *
     * This endpoint collects (hardware) information from your server.
     * <aside class="notice">You don't need to implement this endpoint. It's used by the server script and
     * documented here for a transparent look inside this tool.</aside>
     * <aside class="warning">Throttle: 1 request every 300 sec.</aside>
     * @bodyParam load_avg float required Current average load in GB as float. Example: 0.23
     * @bodyParam num_cores integer required Number of cores of the system. Example: 8
     * @bodyParam hdd_used float required Used HDD memory in GB as float. Example: 152
     * @bodyParam hdd_total float required Total available HDD in GB memory as float. Example: 508.76
     * @bodyParam ram_used float required Used RAM in GB as float. Example: 1.5
     * @bodyParam ram_total float required Total available RAM in GB as float. Example: 16.23
     * @group     Server-Script
     * @response  scenario=Success {"message":"ok"}
     */
    public function storeServerStats(ServerStatsRequest $request, ServerStatService $service): JsonResponse
    {
        $service->store($request);

        // @todo implement an analysation of the data
        $apiKey = $request->get('api_key');
        if ($apiKey->webhook && $apiKey->cooldown(Cooldown::WEBHOOK_SERVER_STATS)->passed()) {
            app(WebhookService::class)->sendWebhook($apiKey, true, false);
            $apiKey->cooldown(Cooldown::WEBHOOK_SERVER_STATS)->until(now()->addMinutes(Cooldown::COOLDOWN_MIN[Cooldown::WEBHOOK_SERVER_STATS]));
        }

        return response()->json([
            'message' => 'ok',
        ], JsonResponse::HTTP_OK);
    }

    /**
     * Server Stats
     *
     * Pull the latest server stats posted to the health API by your server. All data (except load_avg) are in GB.
     * @group         Pull Information
     * @response      scenario=Success
     *           {"data":[{"type":"hdd_total","value":933.22},{"type":"num_cores","value":8},{"type":"hdd_used","value":53.22},{"type":"ram_total","value":125.22},{"type":"load_avg","value":0.22},{"type":"ram_used","value":2.22}],"latest_update":"2021-08-31T14:14:15.000000Z"}
     * @responseField ram_total float Available RAM in GB
     * @responseField ram_used float Used RAM in GB
     * @responseField hdd_used float Available hdd memory in GB
     * @responseField hdd_total float Used hdd memory in GB
     * @responseField load_avg float Current load avg over the last 5min
     * @responseField num_cores integer Number of cpu cores
     */
    public function getServerStats(ServerStatRepository $repository): ServerStatCollection
    {
        return new ServerStatCollection($repository->getLatestServerStatForApiKey(request('api_key')));
    }
}
