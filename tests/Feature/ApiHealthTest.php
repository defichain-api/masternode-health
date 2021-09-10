<?php

namespace Tests\Feature;

use Tests\TestCase;

class ApiHealthTest extends TestCase
{
    public function test_health_request(): void
    {
        $this->prepareServerStatData();
        $response = $this->get(route('api.health'));
        $response->assertStatus(200);
        $this->assertTrue($response->json('database_connection'));
        $this->assertTrue($response->json('redis_connection'));
        $this->assertTrue($response->json('new_data_in_period'));
    }

    public function test_health_request_fails(): void
    {
        config(['database.redis.default.host' => 'not_reachable.com']);

        $response = $this->get(route('api.health'));
        $response->assertStatus(500);
        $this->assertFalse($response->json('new_data_in_period'), 'No new data in period is available');
        $this->assertFalse($response->json('redis_connection'), 'Redis is not reachable at the moment');
        $this->assertTrue($response->json('database_connection'), 'Database is not reachable at the moment');
    }

    public function test_data_status_request(): void
    {
        $apiKey = $this->prepareServerStatData();
        $response = $this->withHeaders(['x-api-key' => $apiKey->key()])
            ->get(route('api.v1.get.data-status'));
        $response->assertStatus(200);
        $this->assertEquals(3, $response->json('new_data_in_period'));
        $this->assertEquals(0, $response->json('latest_data_diff_minutes'));
    }
}
