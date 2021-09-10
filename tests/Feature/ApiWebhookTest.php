<?php

namespace Tests\Feature;

use App\Models\ApiKey;
use App\Models\Webhook;
use Faker\Factory;
use Tests\TestCase;

class ApiWebhookTest extends TestCase
{
    public function test_create_webhook(): void
    {
        $this->withoutApiThrottleMiddleware();
        $response = $this->withHeaders([
            'x-api-key' => ApiKey::factory()->create()->id,
        ])->post(route('api.v1.webhook.create'), [
            'url' => 'https://defichain.com/',
        ]);

        $this->assertEquals('webhook created', $response->json('message'));
        $response->assertStatus(200);
    }

    public function test_create_webhook_fails(): void
    {
        $this->withoutApiThrottleMiddleware();
        $faker = Factory::create();

        $response = $this->withHeaders([
            'x-api-key' => 'wrong-api-key',
        ])->post(route('api.v1.webhook.create'), [
            'url' => $faker->url,
        ]);
        $response->assertStatus(401);
    }

    public function test_delete_webhook(): void
    {
        $this->withoutApiThrottleMiddleware();
        /** @var Webhook $webhook */
        $webhook = Webhook::factory()->create();
        $response = $this->withHeaders([
            'x-api-key' => $webhook->apiKey->key(),
        ])->delete(route('api.v1.webhook.delete'), []);

        $this->assertEquals('webhook deleted', $response->json('message'));
        $response->assertStatus(200);
    }

    public function test_delete_webhook_fails(): void
    {
        $this->withoutApiThrottleMiddleware();
        $response = $this->withHeaders([
            'x-api-key' => ApiKey::factory()->create()->id,
        ])->delete(route('api.v1.webhook.delete'), []);

        $this->assertEquals('webhook not existing or could not delete', $response->json('message'));
        $response->assertStatus(422);
    }
}
