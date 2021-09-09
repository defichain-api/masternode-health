<?php

namespace Tests\Feature;

use App\Enum\ServerStatTypes;
use App\Models\ApiKey;
use App\Models\ServerStat;
use Str;
use Tests\TestCase;

class ApiTest extends TestCase
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

    public function test_receive_server_stat(): void
    {
        $apiKey = $this->prepareServerStatData();

        $response = $this->withHeaders(['x-api-key' => $apiKey->id])
            ->get(route('api.v1.get.server-stats'));
        ray($response->json());
        $response->assertStatus(200);
        $this->assertEquals(3, count($response->json('data')));
    }

    public function test_receive_server_stat_unauthenticated(): void
    {
        $responses = [
            $this->withHeaders(['x-api-key' => Str::random(32)])
                ->get(route('api.v1.get.server-stats')),
            $this->get(route('api.v1.get.server-stats')),
        ];

        foreach ($responses as $response) {
            $response->assertStatus(401);
            $this->assertEquals('error', $response->json('state'));
            $this->assertEquals('not authorized', $response->json('reason'));
        }
    }

    public function test_receive_node_info_unauthenticated(): void
    {
        $responses = [
            $this->withHeaders(['x-api-key' => Str::random(32)])
                ->get(route('api.v1.get.node-info')),
            $this->get(route('api.v1.get.node-info')),
        ];

        foreach ($responses as $response) {
            $response->assertStatus(401);
            $this->assertEquals('error', $response->json('state'));
            $this->assertEquals('not authorized', $response->json('reason'));
        }
    }

    protected function prepareServerStatData(): ApiKey
    {
        $apiKey = ApiKey::factory()->create();

        ServerStat::factory()
            ->serverStat(ServerStatTypes::RAM_TOTAL)
            ->apiKey($apiKey->id)
            ->create();

        ServerStat::factory()
            ->serverStat(ServerStatTypes::RAM_USED)
            ->apiKey($apiKey->id)
            ->create();

        ServerStat::factory()
            ->serverStat(ServerStatTypes::LOAD_AVG)
            ->apiKey($apiKey->id)
            ->create();

        return $apiKey;
    }
}
