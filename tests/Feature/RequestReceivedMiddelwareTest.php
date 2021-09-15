<?php

namespace Tests\Feature;

use App\Models\Statistic;
use App\Repository\StatisticRepository;
use Tests\TestCase;

class RequestReceivedMiddelwareTest extends TestCase
{
    public function test_request_received_increment_db(): void
    {
        $requestsTodayBefore = app(StatisticRepository::class)::today()->request_received_count ?? 0;
        $response = $this->get(route('api.ping'));
        $response->assertStatus(200);
        $this->assertDatabaseHas(Statistic::class, [
            'request_received_count' => $requestsTodayBefore + 1,
            'date'                   => today(),
        ]);
    }
}
