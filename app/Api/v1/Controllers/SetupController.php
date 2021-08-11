<?php

namespace App\Api\v1\Controllers;

use App\Api\v1\Requests\ServerKeyRequest;
use App\Service\ApiKeyService;
use App\Service\ServerService;
use Illuminate\Http\JsonResponse;

class SetupController
{
    /**
     * Get an API Key
     *
     * create a new API key.
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
     * Get a server key
     *
     * Create a key for your fullnode / masternode server. You need to generate an API key before.
     * @bodyParam api_key string required Your API key Example: c7654335-3e00-41ee-a879-3011c5399d89
     * @bodyParam name string Name of this node server Example: My Masternode
     * @response  scenario=Success {"message":"server key generated","server_key":"136b4844-f7b3-4b02-8f32-2ade39264c83"}
     * @group     Setup
     * @unauthenticated
     */
    public function setupServerKey(ServerService $serverKeyService, ServerKeyRequest $request): JsonResponse
    {
        return response()->json([
            'message'    => 'server key generated',
            'server_key' => $serverKeyService->generateKey($request->apiKey(), $request->name()),
        ], JsonResponse::HTTP_OK);
    }
}
