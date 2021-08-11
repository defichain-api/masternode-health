<?php

namespace App\Api\v1\Controllers;

use App\Enum\Cooldown;
use App\Api\v1\Requests\BlockInfoRequest;
use App\Api\v1\Requests\ServerStatsRequest;
use App\Service\BlockInfoService;
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

    public function blockInfo(BlockInfoRequest $request, BlockInfoService $service): JsonResponse
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

    public function serverStats(ServerStatsRequest $request, ServerStatService $service): JsonResponse
    {
        $service->store($request);

        return response()->json([
            'message' => 'ok',
        ], JsonResponse::HTTP_OK);
    }
}
