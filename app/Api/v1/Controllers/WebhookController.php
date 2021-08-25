<?php

namespace App\Api\v1\Controllers;

use App\Api\v1\Requests\WebhookCreateRequest;
use App\Service\WebhookService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WebhookController
{
    protected WebhookService $webhookService;

    public function __construct(WebhookService $webhookService)
    {
        $this->webhookService = $webhookService;
    }

    public function create(WebhookCreateRequest $request): JsonResponse
    {
        $this->webhookService->createWebhook($request);

        return response()->json([
            'message' => 'webhook created',
        ], JsonResponse::HTTP_OK);
    }

    public function delete(Request $request)
    {
        if (!$this->webhookService->deleteWebhook($request)) {
            return response()->json([
                'message' => 'webhook not existing or could not delete',
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        return response()->json([
            'message' => 'webhook deleted',
        ], JsonResponse::HTTP_OK);
    }
}
