<?php

namespace Tests\Feature;

use App\Models\Statistic;
use App\Repository\StatisticRepository;
use Tests\TestCase;

class StatisticEndpointTest extends TestCase
{
    protected int $countBefore = 0;

    public function setUp(): void
    {
        parent::setUp();

        // create statistics for 1 month
        $this->countBefore = Statistic::count();
        $this->artisan('statistic:finalize --forLastDays=30');
    }

    public function test_statistic_last_week(): void
    {
        $statisticLastWeek = app(StatisticRepository::class)::lastWeek();
        $response = $this->get(route('api.statistic.last_week'));
        $response->assertStatus(200);
        $this->assertEquals($statisticLastWeek->count(), count($response->json('data')));
    }

    public function test_statistic_alltime(): void
    {
        $responsePage1 = $this->get(route('api.statistic.all'));
        $responsePage1->assertStatus(200);
        $this->assertEquals(StatisticRepository::MAX_PER_PAGE, count($responsePage1->json('data')['data']));
    }
}
