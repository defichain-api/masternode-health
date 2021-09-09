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
        $this->withoutApiThrottleMiddleware();
        $response = $this->get(route('api.setup.api_key'));
        $apiKey = $response->json('api_key');

        $response->assertStatus(200);
        $this->assertEquals('API key generated', $response->json('message'), 'API should answer "API key generated"');
        $this->assertNotNull($apiKey, 'API key needs to be part of the response');
        $this->assertTrue(Str::isUuid($apiKey), 'API key should be a valid UUID');
    }
}
