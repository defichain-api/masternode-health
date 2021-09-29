<?php

namespace App\Service;

use App\Api\v1\DataAnalyser\BaseAnalyzer;
use App\Api\v1\Resources\ServerStatCollection;
use App\Models\ApiKey;
use App\Models\Service\StatisticService;
use Exception;
use Illuminate\Support\Collection;
use Log;
use Spatie\WebhookServer\WebhookCall;

class WebhookService
{
    protected ApiKey $apiKey;
    protected Collection $payloadData;
    protected BaseAnalyzer $analyzer;

    public function setInfo(
        ApiKey $apiKey,
        BaseAnalyzer $analyzer,
        Collection $payloadData
    ): self {
        $this->apiKey = $apiKey;
        $this->payloadData = $payloadData;
        $this->analyzer = $analyzer;

        return $this;
    }

    public function sendWebhook(): void
    {
        if (is_null($this->apiKey)
            || is_null($this->apiKey->webhook)
            || (!$this->analyzer->hasWarnings() && !$this->analyzer->hasFatalErrors())) {
            return;
        }

        /** @var \App\Models\Webhook $webhook */
        $webhook = $this->apiKey->webhook;
        try {
            WebhookCall::create()
                ->url($webhook->url)
                ->maximumTries($webhook->max_tries)
                ->timeoutInSeconds($webhook->timeout_in_seconds)
                ->payload((new ServerStatCollection($this->payloadData, $this->analyzer))->resolve())
                ->useSecret(bcrypt($this->apiKey->key()))
                ->dispatch();
            app(StatisticService::class)->webhookSent();
        } catch (Exception $e) {
            Log::error('webhook sent failed', [
                'message' => $e->getMessage(),
                'line'    => $e->getLine(),
                'file'    => $e->getFile(),
                'code'    => $e->getCode(),
            ]);
        }
    }
}
