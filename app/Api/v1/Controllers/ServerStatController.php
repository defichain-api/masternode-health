<?php

namespace App\Api\v1\Controllers;

use App\Api\v1\DataAnalyser\NodeInfoAnalyzer;
use App\Api\v1\DataAnalyser\ServerStatAnalyzer;
use App\Api\v1\Resources\ServerStatCollection;
use App\Api\v1\Requests\NodeInfoRequest;
use App\Api\v1\Requests\ServerStatsRequest;
use App\Repository\ServerStatRepository;
use App\Service\NodeInfoService;
use App\Service\ServerStatService;
use App\Service\WebhookService;
use Illuminate\Http\JsonResponse;

class ServerStatController
{
    /**
     * Fullnode Info
     *
     * This endpoint collects information from your running fullnode.
     * <aside class="notice">You don't need to implement this endpoint. It's used by the server script and
     * documented here for a transparent look inside this tool.</aside>
     * <aside class="warning">Throttle: 1 request every 300 sec.</aside>
     * @bodyParam block_height_local integer The number of the current block. Example: 1131998
     * @bodyParam local_hash string Hash for the current block. Required length of 64 chars. Example:
     * cefe56ff49a94787a8e8c65da5c4ead6e748838ece6721a06624de15875395a3
     * @bodyParam node_uptime integer Uptime of the fullnode in seconds. Example: 1343121
     * @bodyParam defid_running boolean Check if the DEFID on the server is running Example: true
     * @bodyParam node_version string DeFiChain Node Version. Example: 1.6.3
     * @bodyParam connection_count integer Count of the current fullnode connections. Example: 91
     * @bodyParam logsize float Size of the debug.log file in MB. Example: 13.21
     * @bodyParam config_checksum string MD5 Hash of the defi.conf file. Example: a3cca2b2aa1e3b5b3b5aad99a8529074
     * @bodyParam operator_status object[] Online/Offline information for all masternodes registered on the
     * fullnode. Example: {"id":"cb09568143d7bae6822a7a78f91cb907c23fd12dcf986d4d2c8de89457edf87","online": false}
     * @bodyParam operator_status[].id string Masternode ID Example:
     * 8cb09568143d7bae6822a7a78f91cb907c23fd12dcf986d4d2c8de89457edf87
     * @bodyParam operator_status[].online bool
     * @group     Server-Script
     * @response  scenario=Success {"message":"ok"}
     * @authenticated
     */
    public function storeNodeInfo(
        NodeInfoRequest $request,
        NodeInfoService $service,
        NodeInfoAnalyzer $analyzer,
        WebhookService $webhookService
    ): JsonResponse {
        $service->store($request);
        $storedNodeInfo = $service->store($request);
        $analyzer->withCollection($storedNodeInfo)->analyze();

        /** @var \App\Models\ApiKey $apiKey */
        $apiKey = $request->get('api_key');
        $webhookService
            ->setInfo($apiKey, $analyzer, $storedNodeInfo)
            ->checkAndSendWebhook();

        return response()->json([
            'message' => 'ok',
        ], JsonResponse::HTTP_OK);
    }

    /**
     * Fullnode Info
     *
     * Pull the latest fullnode info posted to the health API by your server.
     * @group         Pull Information
     * @response      scenario=Success {"data":[{"type":"config_checksum","value":"a3cca2b2aa1e3b5b3b5aad99a8529074"},
     * {"type":"defid_running","value":true},{"type":"operator_status",
     * "value":[{"id":"8cb09568143d7bae6822a7a78f91cb907c23fd12dcf986d4d2c8de89457edf87","online":true},{"id":"2ceb7c9c3bea0bd0e5e4199eca5d0b797d79a0077a9108951faecf715e1e1a57","online":true}]},{"type":"node_uptime","value":261124},{"type":"local_hash","value":"0d82efc6638c91279e5f493053075226619080515d2f9b583f8cfc42a4f08885"},{"type":"block_height_local","value":1132261},{"type":"connection_count","value":91},{"type":"logsize","value":13.21},{"type":"node_version","value":"1.6.3"}],"latest_update":"2021-08-31T14:14:12.000000Z"}
     * @responseField block_height_local integer Local Block height
     * @responseField operator_status object Lists the masternode id and it's online status
     * @responseField node_uptime integer Uptime of the node in seconds
     * @responseField node_version string Current version of the node
     * @responseField config_checksum string MD5 hash of the defi.conf file
     * @responseField local_hash string block hash of the current block
     * @responseField connection_count integer Number of current connections to the node
     * @responseField logsize numeric Size of the debug.log in MB
     * @responseField defid_running boolean Flag if the DEFID is running. Example: true
     */
    public function getNodeInfo(ServerStatRepository $repository, NodeInfoAnalyzer $analyzer): ServerStatCollection
    {
        /** @var \App\Models\ApiKey $apiKey */
        $apiKey = request('api_key');
        $resourceCollection = $repository->getLatestNodeInfoForApiKey($apiKey);

        return new ServerStatCollection(
            $resourceCollection,
            $analyzer->withCollection($resourceCollection)
        );
    }

    /**
     * Server Stats
     *
     * This endpoint collects (hardware) information from your server.
     * <aside class="notice">You don't need to implement this endpoint. It's used by the server script and
     * documented here for a transparent look inside this tool.</aside>
     * <aside class="warning">Throttle: 1 request every 300 sec.</aside>
     * @bodyParam load_avg float Current average load in GB as float. Example: 0.23
     * @bodyParam num_cores integer Number of cores of the system. Example: 8
     * @bodyParam hdd_used float Used HDD memory in GB as float. Example: 152
     * @bodyParam hdd_total float Total available HDD in GB memory as float. Example: 508.76
     * @bodyParam ram_used float Used RAM in GB as float. Example: 1.5
     * @bodyParam ram_total float Total available RAM in GB as float. Example: 16.23
     * @bodyParam server_script_version string The current version of the python server script. Example: 1.0.1
     * @group     Server-Script
     * @response  scenario=Success {"message":"ok"}
     */
    public function storeServerStats(
        ServerStatsRequest $request,
        ServerStatService $service,
        ServerStatAnalyzer $analyzer,
        WebhookService $webhookService
    ): JsonResponse {
        $storedServerStats = $service->store($request);
        $analyzer->withCollection($storedServerStats)->analyze();

        /** @var \App\Models\ApiKey $apiKey */
        $apiKey = $request->get('api_key');
        $webhookService
            ->setInfo($apiKey, $analyzer, $storedServerStats)
            ->checkAndSendWebhook();

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
     *           {"data":[{"type":"hdd_total","value":933.22},{"type":"server_script_version","value":"1.0.1"},
     * {"type":"num_cores","value":8},{"type":"hdd_used","value":53.22},{"type":"ram_total","value":125.22},{"type":"load_avg","value":0.22},{"type":"ram_used","value":2.22}],"latest_update":"2021-08-31T14:14:15.000000Z"}
     * @responseField ram_total float Available RAM in GB
     * @responseField ram_used float Used RAM in GB
     * @responseField hdd_used float Available hdd memory in GB
     * @responseField hdd_total float Used hdd memory in GB
     * @responseField load_avg float Current load avg over the last 5min
     * @responseField num_cores integer Number of cpu cores
     * @responseField server_script_version string Current Version of the server script. Example: 1.0.1
     */
    public function getServerStats(ServerStatRepository $repository, ServerStatAnalyzer $analyzer): ServerStatCollection
    {
        /** @var \App\Models\ApiKey $apiKey */
        $apiKey = request('api_key');
        $resourceCollection = $repository->getLatestServerStatForApiKey($apiKey);

        return new ServerStatCollection($resourceCollection, $analyzer->withCollection($resourceCollection));
    }
}
