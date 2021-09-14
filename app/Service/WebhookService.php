<?php

namespace App\Service;

use App\Api\v1\Requests\WebhookCreateRequest;
use App\Api\v1\Resources\ServerStatCollection;
use App\Models\ApiKey;
use App\Models\Service\StatisticService;
use App\Models\Webhook;
use App\Repository\ServerStatRepository;
use Illuminate\Http\Request;
use Spatie\WebhookServer\WebhookCall;

class WebhookService
{
    const DEFAULT_MAX_TRIES = 3;
    const DEFAULT_TIMEOUT = 3;

    public function createWebhook(WebhookCreateRequest $request): bool
    {
        return Webhook::updateOrCreate([
            'api_key_id' => $request->get('api_key')->key(),
        ], [
            'url'                => $request->input('url'),
            'max_tries'          => $request->input('max_tries') ?? self::DEFAULT_MAX_TRIES,
            'timeout_in_seconds' => $request->input('timeout_in_seconds') ?? self::DEFAULT_TIMEOUT,
            'reference'          => $request->input('reference') ?? null,
        ]) ? true : false;
    }

    public function deleteWebhook(Request $request): bool
    {
        /** @var ApiKey $apiKey */
        $apiKey = $request->get('api_key');
        $webhook = Webhook::whereApiKeyId($apiKey->key())->first();

        return isset($webhook) ? $webhook->delete() : false;
    }

    public function sendWebhook(ApiKey $apiKey, bool $serverStats = false, bool $nodeInfo = false)
    {
        if ($serverStats) {
            $payloadData = app(ServerStatRepository::class)->getLatestServerStatForApiKey($apiKey);
        } elseif ($nodeInfo) {
            $payloadData = app(ServerStatRepository::class)->getLatestNodeInfoForApiKey($apiKey);
        }
        app(StatisticService::class)->webhookSent();

        /** @var \App\Models\Webhook $webhook */
        $webhook = $apiKey->webhook;
        WebhookCall::create()
            ->url($webhook->url)
            ->maximumTries($webhook->max_tries)
            ->timeoutInSeconds($webhook->timeout_in_seconds)
            ->payload((new ServerStatCollection($payloadData))->resolve())
            ->useSecret($apiKey->key())
            ->dispatch();
    }
}
