<?php

namespace App\Api\v1\Controllers;

use App\Api\v1\Resources\ServerStatCollection;
use App\Api\v1\Requests\NodeInfoRequest;
use App\Api\v1\Requests\ServerStatsRequest;
use App\Repository\ServerStatRepository;
use App\Service\NodeInfoService;
use App\Service\ServerStatService;
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
     * @bodyParam block_height_local integer required The number of the current block. Example: 1131998
     * @bodyParam local_hash string required Hash for the current block. Required length of 64 chars. Example:
     * cefe56ff49a94787a8e8c65da5c4ead6e748838ece6721a06624de15875395a3
     * @bodyParam node_uptime integer required Uptime of the fullnode in seconds. Example: 1343121
     * @group     Server-Script
     * @response  scenario=Success {"message":"ok"}
     * @authenticated
     */
    public function nodeInfo(NodeInfoRequest $request, NodeInfoService $service): JsonResponse
    {
        $service->store($request);

        // @todo implement an analysation of the data

        return response()->json([
            'message' => 'ok',
        ], JsonResponse::HTTP_OK);
    }

    /**
     * Server Stats
     *
     * This endpoint collects (hardware) information from your server.
     * <aside class="notice">You don't need to implement this endpoint. It's used by the server script and
     * documented here for a transparent look inside this tool.</aside>
     * @bodyParam load_avg  float Current average load as float. Example: 0.23
     * @bodyParam hdd_used  float Used HDD memory as float. Example: 152
     * @bodyParam hdd_total  float Total available HDD memory as float. Example: 508.76
     * @bodyParam ram_used  float Used RAM in GB as float. Example: 1.5
     * @bodyParam ram_total  float Total available RAM in GB as float. Example: 16.23
     * @group     Server-Script
     * @response  scenario=Success {"message":"ok"}
     */
    public function storeServerStats(ServerStatsRequest $request, ServerStatService $service): JsonResponse
    {
        $service->store($request);

        // @todo implement an analysation of the data

        return response()->json([
            'message' => 'ok',
        ], JsonResponse::HTTP_OK);
    }

    /**
     * Server Stats
     *
     * Pull the latest server stats posted to the health API by your server.
     * @response scenario=Success
     *           {"data":[{"type":"ram_total","value":125.724},{"type":"hdd_total","value":933.3428},{"type":"hdd_used","value":53.6456},{"type":"ram_used","value":2.9764},{"type":"load_avg","value":0.22}],"latest_update":"2021-08-25T07:40:09.000000Z"}
     */
    public function getServerStats(ServerStatRepository $repository): ServerStatCollection
    {
        return new ServerStatCollection($repository->getLatestServerStatForApiKey(request('api_key')));
    }
}
