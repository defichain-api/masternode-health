<?php

namespace App\Service;

use App\Api\v1\DataAnalyser\BaseAnalyzer;
use App\Api\v1\Resources\ServerStatCollection;
use App\Enum\Cooldown;
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
    protected bool $webhookEnabled = false;

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

    protected function sendWebhook(): void
    {
        if (!$this->webhookEnabled) {
            return;
        }
        app(StatisticService::class)->webhookSent();

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
        } catch (Exception $e) {
            Log::error('webhook sent failed', [
                'message' => $e->getMessage(),
                'line'    => $e->getLine(),
                'code'    => $e->getCode(),
            ]);

            return;
        }
        $analyzerType = $this->analyzer->getAnalyzerType();
        $this->apiKey->cooldown($analyzerType)->until(now()->addHours(Cooldown::COOLDOWN_IN_HOURS[$analyzerType]));
        $this->webhookEnabled = false;
    }

    public function checkAndSendWebhook(): void
    {
        if (
            isset($this->apiKey)
            && $this->apiKey->webhook
            && ($this->analyzer->hasWarnings() || $this->analyzer->hasFatalErrors())
            && $this->apiKey->cooldown($this->analyzer->getAnalyzerType())->passed()
        ) {
            $this->webhookEnabled = true;
            $this->sendWebhook();
        }
    }
}
