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
            ->apiKey($apiKey->key())
            ->create();

        ServerStat::factory()
            ->serverStat(ServerStatTypes::NODE_VERSION)
            ->apiKey($apiKey->key())
            ->create();

        ServerStat::factory()
            ->serverStat(ServerStatTypes::BLOCK_HEIGHT, 1231231212)
            ->apiKey($apiKey->key())
            ->create();

        ServerStat::factory()
            ->serverStat(ServerStatTypes::LOCAL_HASH)
            ->apiKey($apiKey->key())
            ->create();

        ServerStat::factory()
            ->serverStat(ServerStatTypes::DEFID_RUNNING, true)
            ->apiKey($apiKey->key())
            ->create();

        ServerStat::factory()
            ->serverStat(ServerStatTypes::OPERATOR_STATUS, json_encode([['id'=>'1231231231231', 'online' => true]]))
            ->apiKey($apiKey->key())
            ->create();

        return $apiKey;
    }

    protected function prepareServerStatData(): ApiKey
    {
        $apiKey = ApiKey::factory()->create();

        ServerStat::factory()
            ->serverStat(ServerStatTypes::RAM_TOTAL)
            ->apiKey($apiKey->key())
            ->create();

        ServerStat::factory()
            ->serverStat(ServerStatTypes::RAM_USED)
            ->apiKey($apiKey->key())
            ->create();

        ServerStat::factory()
            ->serverStat(ServerStatTypes::LOAD_AVG, 0.06)
            ->apiKey($apiKey->key())
            ->create();

        return $apiKey;
    }
}
