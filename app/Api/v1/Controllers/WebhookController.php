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

    /**
     * Create Webhook
     *
     * Get informed by webhooks with the current data of your server. You'll receive webhooks only every 5 minutes.
     * @bodyParam url required URL receiving the webhooks. Has to be public reachable. Example:
     *            https://your-domain.com/defichain-masternode-health/webhook
     * @group     Webhooks
     */
    public function create(WebhookCreateRequest $request): JsonResponse
    {
        if (!$this->webhookService->createWebhook($request)) {
            return response()->json([
                'message' => 'error while creating webhook',
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        return response()->json([
            'message' => 'webhook created',
        ], JsonResponse::HTTP_OK);
    }

    /**
     * Delete Webhook
     *
     * To delete your already setup webhook just call this `DELETE` endpoint.
     * @group Webhooks
     */
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
