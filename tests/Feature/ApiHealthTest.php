<?php

namespace Tests\Feature;

use Tests\ApiTestCase;

class ApiHealthTest extends ApiTestCase
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
        $response = $this->get(route('api.health'));
        $response->assertStatus(500);
        $this->assertFalse($response->json('new_data_in_period'));
        $this->assertTrue($response->json('database_connection'));
        $this->assertTrue($response->json('redis_connection'));
    }

    public function test_data_status_request(): void
    {
        $apiKey = $this->prepareServerStatData();
        $response = $this->withHeaders(['x-api-key' => $apiKey->id])
            ->get(route('api.v1.get.data-status'));
        $response->assertStatus(200);
        $this->assertEquals(3, $response->json('new_data_in_period'));
        $this->assertEquals(0, $response->json('latest_data_diff_minutes'));
    }
}
