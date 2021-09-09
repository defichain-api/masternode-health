<?php

namespace Tests\Feature;

use Str;
use Tests\TestCase;

class ApiSetupTest extends TestCase
{
    public function test_ping_api(): void
    {
        $response = $this->get(route('api.ping'));
        $response->assertStatus(200);
        $this->assertEquals('pong', $response->json('message'), 'Expected "pong" as response on "ping".. makes sense?');
    }

    public function test_setup_api_key(): void
    {
        $response = $this->get(route('api.setup.api_key'));
        $apiKey = $response->json('api_key');

        $response->assertStatus(200);
        $this->assertEquals('API key generated', $response->json('message'), 'API should answer "API key generated"');
        $this->assertNotNull($apiKey, 'API key needs to be part of the response');
        $this->assertTrue(Str::isUuid($apiKey), 'API key should be a valid UUID');
    }

    public function test_throttle_setup_api_key(): void
    {
        $this->get(route('api.setup.api_key'));
        $response = $this->get(route('api.setup.api_key'));

        $response->assertStatus(429);
        $response->assertJsonFragment([
            'code'    => 429,
            'message' => 'Too Many Attempts. Only 1 requests are allowed every 60 seconds. After 60 seconds you can access this endpoint again.',
        ]);
    }
}
