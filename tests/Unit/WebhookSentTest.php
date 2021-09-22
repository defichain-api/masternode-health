<?php

namespace Tests\Unit;

use App\Api\v1\DataAnalyser\NodeInfoAnalyzer;
use App\Models\Webhook;
use App\Repository\ServerStatRepository;
use App\Service\WebhookService;
use Queue;
use Spatie\WebhookServer\CallWebhookJob;
use Tests\TestCase;

class WebhookSentTest extends TestCase
{
    public function test_send_webhook(): void
    {
        Queue::fake();
        $this->assertDatabaseMissing('statistics', [
            'date'               => today(),
            'webhook_sent_count' => 1,
        ]);
        $apiKey = $this->prepareNodeInfoData();
        Webhook::factory()->apiKey($apiKey->key())->create();
        $serverStats = app(ServerStatRepository::class)->getLatestNodeInfoForApiKey($apiKey);
        $analyzer = (new NodeInfoAnalyzer())->withCollection(
            $serverStats
        )->analyze();

        Queue::assertNothingPushed();
        app(WebhookService::class)->setInfo($apiKey, $analyzer, $serverStats)
            ->sendWebhook();
        Queue::assertPushed(CallWebhookJob::class, 1);

        $this->assertDatabaseHas('statistics', [
            'date'               => today(),
            'webhook_sent_count' => 1,
        ]);
    }
}
