<?php

namespace App\Api\v1\Controllers;

use App\Enum\Cooldown;
use App\Api\v1\Requests\NodeInfoRequest;
use App\Api\v1\Requests\ServerStatsRequest;
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
     * @bodyParam connectioncount integer
     * @bodyParam block_diff integer required
     * @bodyParam block_height_local integer required
     * @bodyParam main_net_block_height integer required
     * @bodyParam local_hash string required
     * @bodyParam main_net_block_hash string required
     * @bodyParam local_split_found boolean required
     * @bodyParam logsize integer required
     * @bodyParam node_uptime integer Uptime of the fullnode in seconds. Example: 1343121
     * @header    x-api-key bffd1dfd-63b8-48f2-afe6-f4318cce86ef
     * @header    x-server-key 05dbded5-0084-40e1-ab4d-064859440369
     * @group     Server-Script
     * @response  scenario=Success {"message":"ok"}
     * @authenticated
     */
    public function nodeInfo(NodeInfoRequest $request, NodeInfoService $service): JsonResponse
    {
        $service->store($request);

        if ($request->localSplitFound() &&
            $request->getServer()->cooldown(Cooldown::LOCAL_SPLIT_NOTIFICATION)->passed()) {
            $service->sendLocalSplitNotification($request);
        }

        if ($request->blockHeightLocal() > $request->mainNetBlockHeight() &&
            $request->getServer()->cooldown(Cooldown::REMOTE_SPLIT_NOTIFICATION)->passed()) {
            $service->sendRemoteSplitNotification($request);
        }

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
     * @bodyParam cpu  string Current average load. Example: 0.23,0.55,0.98
     * @bodyParam hdd_used  string Used HDD memory. Example: 152
     * @bodyParam hdd_total  string Total available HDD memory. Example: 512
     * @bodyParam ram_used  string Used RAM in GB. Example: 1.5
     * @bodyParam ram_total  string Total available RAM in GB. Example: 16
     * @header    x-api-key bffd1dfd-63b8-48f2-afe6-f4318cce86ef
     * @header    x-server-key 05dbded5-0084-40e1-ab4d-064859440369
     * @group     Server-Script
     * @response  scenario=Success {"message":"ok"}
     * @authenticated
     */
    public function serverStats(ServerStatsRequest $request, ServerStatService $service): JsonResponse
    {
        $service->store($request);

        return response()->json([
            'message' => 'ok',
        ], JsonResponse::HTTP_OK);
    }
}
