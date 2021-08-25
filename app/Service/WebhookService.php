<?php

namespace App\Service;

use App\Api\v1\Requests\WebhookCreateRequest;
use App\Models\Webhook;
use Illuminate\Http\Request;

class WebhookService
{
    const DEFAULT_MAX_TRIES = 3;
    const DEFAULT_TIMEOUT = 3;

    public function createWebhook(WebhookCreateRequest $request): bool
    {
        return Webhook::updateOrCreate([
            'api_key_id' => $request->get('api_key')->id,
        ], [
            'url'                => $request->input('url'),
            'max_tries'          => $request->input('max_tries') ?? self::DEFAULT_MAX_TRIES,
            'timeout_in_seconds' => $request->input('timeout_in_seconds') ?? self::DEFAULT_TIMEOUT,
        ]) ? true : false;
    }

    public function deleteWebhook(Request $request): bool
    {
        $webhook = Webhook::whereApiKeyId($request->get('api_key')->id)->first();
        return isset($webhook) ? $webhook->delete() : false;
    }
}
