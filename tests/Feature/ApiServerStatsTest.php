<?php

namespace Tests\Feature;

use App\Models\ApiKey;
use Faker\Factory;
use Str;
use Tests\TestCase;

class ApiServerStatsTest extends TestCase
{
    public function test_receive_server_stat(): void
    {
        $this->withoutApiThrottleMiddleware();
        $apiKey = $this->prepareServerStatData();

        $response = $this->withHeaders(['x-api-key' => $apiKey->key()])
            ->get(route('api.v1.get.server-stats'));
        $response->assertStatus(200);
        $this->assertEquals(3, count($response->json('data')));
    }

    public function test_receive_node_info(): void
    {
        $this->withoutApiThrottleMiddleware();
        $apiKey = $this->prepareNodeInfoData();

        $response = $this->withHeaders(['x-api-key' => $apiKey->key()])
            ->get(route('api.v1.get.node-info'));
        $response->assertStatus(200);
        $this->assertEquals(6, count($response->json('data')));
    }

    public function test_receive_server_stat_unauthenticated(): void
    {
        $this->withoutApiThrottleMiddleware();
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
        $this->withoutApiThrottleMiddleware();
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

    public function test_store_node_info(): void
    {
        $this->withoutApiThrottleMiddleware();
        $response = $this->withHeaders([
            'x-api-key' => ApiKey::factory()->create()->id,
        ])->post(route('api.v1.post.node-info'), $this->prepareNodeInfoPostData());
        $response->assertStatus(200);
        $this->assertEquals('ok', $response->json('message'));
    }

    public function test_store_server_stats(): void
    {
        $this->withoutApiThrottleMiddleware();
        $response = $this->withHeaders([
            'x-api-key' => ApiKey::factory()->create()->id,
        ])->post(route('api.v1.post.server-stats'), $this->prepareServerStatPostData());
        $response->assertStatus(200);
        $this->assertEquals('ok', $response->json('message'));
    }

    protected function prepareNodeInfoPostData(): array
    {
        $faker = Factory::create();

        return [
            'block_height_local' => $faker->numberBetween(111111, 999999),
            'local_hash'         => Str::random(64),
            'defid_running'      => $faker->boolean(90),
            'node_uptime'        => $faker->numberBetween(0, 999999),
            'connection_count'   => $faker->numberBetween(1, 199),
            'logsize'            => $faker->randomFloat(2, 1, 20),
            'node_version'       => Str::random(15),
            'operator_status'    => [
                [
                    'id'     => Str::random(64),
                    'online' => $faker->boolean(80),
                ],
                [
                    'id'     => Str::random(64),
                    'online' => $faker->boolean(80),
                ],
            ],
        ];
    }

    protected function prepareServerStatPostData(): array
    {
        $faker = Factory::create();

        return [
            'load_avg'              => $faker->randomFloat(2, 0, 1),
            'num_cores'             => 0,
            'hdd_used'              => $faker->randomFloat(2, 3, 512),
            'hdd_total'             => $faker->numberBetween(512, 1024),
            'ram_used'              => $faker->randomFloat(2, 2, 8),
            'ram_total'             => $faker->randomFloat(2, 8, 32),
            'server_script_version' => sprintf('1.0.%s', $faker->numberBetween(0, 45)),
        ];
    }
}
