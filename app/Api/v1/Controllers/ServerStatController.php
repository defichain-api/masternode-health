<?php

namespace App\Api\v1\Controllers;

use App\Api\v1\Resources\ServerStatCollection;
use App\Api\v1\Requests\NodeInfoRequest;
use App\Api\v1\Requests\ServerStatsRequest;
use App\Enum\Cooldown;
use App\Repository\ServerStatRepository;
use App\Service\NodeInfoService;
use App\Service\ServerStatService;
use App\Service\WebhookService;
use Illuminate\Http\JsonResponse;

class ServerStatController
{
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
     *
     * Node Uptime in seconds.
     * Log Size in MB.
     * @group     Pull Information
     * @response  scenario=Success
     *           {"data":[{"type":"block_height_local","value":1132261},{"type":"operator_status","value":[{"id":"8cb09568143d7bae6822a7a78f91cb907c23fd12dcf986d4d2c8de89457edf87","online":true},{"id":"2ceb7c9c3bea0bd0e5e4199eca5d0b797d79a0077a9108951faecf715e1e1a57","online":true}]},{"type":"node_uptime","value":261124},{"type":"config_checksum","value":"a3cca2b2aa1e3b5b3b5aad99a8529074"},{"type":"local_hash","value":"0d82efc6638c91279e5f493053075226619080515d2f9b583f8cfc42a4f08885"},{"type":"connection_count","value":91},{"type":"logsize","value":13.21}],"latest_update":"2021-08-29T16:37:38.000000Z"}
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
     * @bodyParam load_avg  float Current average load in GB as float. Example: 0.23
     * @bodyParam num_cores  integer Number of cores of the system. Example: 8
     * @bodyParam hdd_used  float Used HDD memory in GB as float. Example: 152
     * @bodyParam hdd_total  float Total available HDD in GB memory as float. Example: 508.76
     * @bodyParam ram_used  float Used RAM in GB as float. Example: 1.5
     * @bodyParam ram_total  float Total available RAM in GB as float. Example: 16.23
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
     * @group     Pull Information
     * @response  scenario=Success
     *           {"data":[{"type":"ram_total","value":125.724},{"type":"hdd_total","value":933.3428},{"type":"hdd_used","value":53.6456},{"type":"ram_used","value":2.9764},{"type":"load_avg","value":0.22}],"latest_update":"2021-08-25T07:40:09.000000Z"}
     */
    public function getServerStats(ServerStatRepository $repository): ServerStatCollection
    {
        return new ServerStatCollection($repository->getLatestServerStatForApiKey(request('api_key')));
    }
}
