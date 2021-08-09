<?php

namespace App\Api\v1\Controllers;

use App\Api\v1\Requests\ServerKeyRequest;
use App\Service\ApiKeyService;
use App\Service\ServerKeyService;
use Illuminate\Http\JsonResponse;

class SetupController
{
    public function setupApiKey(ApiKeyService $apiKeyService): JsonResponse
    {
        return response()->json([
            'message' => 'API key generated',
            'api_key' => $apiKeyService->generateKey(),
        ], JsonResponse::HTTP_OK);
    }

    public function setupServerKey(ServerKeyService $serverKeyService, ServerKeyRequest $request): JsonResponse
    {
        return response()->json([
            'message'    => 'server key generated',
            'server_key' => $serverKeyService->generateKey($request->apiKey()),
        ], JsonResponse::HTTP_OK);
    }
}
