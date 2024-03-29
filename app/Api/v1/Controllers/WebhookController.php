<?php

namespace App\Api\v1\Controllers;

use App\Api\v1\Requests\WebhookCreateRequest;
use App\Repository\WebhookRepository;
use App\Service\WebhookService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WebhookController
{
    protected WebhookRepository $webhookService;

    public function __construct(WebhookRepository $webhookRepository)
    {
        $this->webhookRepository = $webhookRepository;
    }

    /**
     * Create Webhook
     *
     * Get informed by webhooks with the current data of your server. You'll receive webhooks only every 5 minutes.
     * <aside class="notice">The sent webhooks have the same markup as the pulled information for the node info and server stats
     * .</aside>
     * @bodyParam url string required URL receiving the webhooks. Has to be public reachable. Example:
     *            https://your-domain.com/defichain-masternode-health/webhook
     * @bodyParam max_tries integer The max tries to send the webhook to your url. (between 1..10). Default: 3 Example: 3
     * @bodyParam timeout_in_seconds integer The timeout in seconds (between 1..5) Default: 3 Example: 3
     * @bodyParam reference string To assign a webhook to a specific API key, you can set an optional reference.
     * @group     Webhooks
     */
    public function create(WebhookCreateRequest $request): JsonResponse
    {
        if (!$this->webhookRepository->createWebhook($request)) {
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
        if (!$this->webhookRepository->deleteWebhook($request)) {
            return response()->json([
                'message' => 'webhook not existing or could not delete',
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        return response()->json([
            'message' => 'webhook deleted',
        ], JsonResponse::HTTP_OK);
    }
}
