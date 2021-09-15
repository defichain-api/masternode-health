<?php

namespace Tests\Unit\Commands;

use App\Models\ApiKey;
use App\Models\Statistic;
use DB;
use Tests\TestCase;

class FinalizeStatisticTest extends TestCase
{
    const API_KEY_COUNT = 11;

    public function test_statistic_added(): void
    {
        $apiKeyCountBefore = ApiKey::count();
        $countBefore = Statistic::where('date', '!=', today()->subday())
            ->count();
        ApiKey::factory()->count(self::API_KEY_COUNT)->create();
        $this->artisan('statistic:finalize')->assertExitCode(0);
        $this->assertDatabaseCount(Statistic::class, $countBefore + 1);
        $this->assertEquals(self::API_KEY_COUNT + $apiKeyCountBefore,
            Statistic::where('date', today()->subDay())->first()
                ->api_key_count);
    }

    public function test_min_param(): void
    {
        $this->artisan('statistic:finalize --forLastDays=0')->assertExitCode(1);
    }
}
