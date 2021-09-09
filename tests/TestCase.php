<?php

namespace Tests;

use App\Enum\ServerStatTypes;
use App\Http\Middleware\ApiThrottleRequests;
use App\Models\ApiKey;
use App\Models\ServerStat;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use DatabaseTransactions;

    protected function withoutApiThrottleMiddleware(): void
    {
        $this->withoutMiddleware(ApiThrottleRequests::class);
    }

    protected function prepareNodeInfoData(): ApiKey
    {
        $apiKey = ApiKey::factory()->create();

        ServerStat::factory()
            ->serverStat(ServerStatTypes::NODE_UPTIME)
            ->apiKey($apiKey->id)
            ->create();

        ServerStat::factory()
            ->serverStat(ServerStatTypes::NODE_VERSION)
            ->apiKey($apiKey->id)
            ->create();

        ServerStat::factory()
            ->serverStat(ServerStatTypes::BLOCK_HEIGHT)
            ->apiKey($apiKey->id)
            ->create();

        ServerStat::factory()
            ->serverStat(ServerStatTypes::LOCAL_HASH)
            ->apiKey($apiKey->id)
            ->create();

        return $apiKey;
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
