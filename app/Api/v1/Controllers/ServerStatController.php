<?php

namespace App\Api\v1\Controllers;

use App\Enum\Cooldown;
use App\Http\Requests\BlockInfoRequest;
use App\Http\Requests\ServerStatsRequest;
use App\Service\BlockInfoService;
use Illuminate\Http\JsonResponse;

class ServerStatController
{
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

        if ($request->splitFound() &&
            $request->userServer()->cooldown(Cooldown::LOCAL_SPLIT_NOTIFICATION)->passed()) {
            $service->sendLocalSplitNotification($request);
        }

        if ($request->blockHeightLocal() > $request->mainNetBlockHeight() &&
            $request->userServer()->cooldown(Cooldown::REMOTE_SPLIT_NOTIFICATION)->passed()) {
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
