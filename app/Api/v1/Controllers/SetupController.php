<?php

namespace App\Api\v1\Controllers;

use App\Service\ApiKeyService;
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
}
