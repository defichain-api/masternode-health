<?php

namespace Tests\Feature;

use Str;
use Tests\ApiTestCase;

class ApiServerStatsTest extends ApiTestCase
{
    public function test_receive_server_stat(): void
    {
        $apiKey = $this->prepareServerStatData();

        $response = $this->withHeaders(['x-api-key' => $apiKey->id])
            ->get(route('api.v1.get.server-stats'));
        ray($response->json());
        $response->assertStatus(200);
        $this->assertEquals(3, count($response->json('data')));
    }

    public function test_receive_node_info(): void
    {
        $apiKey = $this->prepareNodeInfoData();

        $response = $this->withHeaders(['x-api-key' => $apiKey->id])
            ->get(route('api.v1.get.node-info'));
        ray($response->json());
        $response->assertStatus(200);
        $this->assertEquals(4, count($response->json('data')));
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
}
