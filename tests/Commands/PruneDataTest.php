<?php

namespace Tests\Commands;

use App\Models\ServerStat;
use Tests\TestCase;

class PruneDataTest extends TestCase
{
    public function test_delete_data(): void
    {
        $countBefore = ServerStat::count();
        $this->assertDatabaseCount('server_stats', $countBefore);

        ServerStat::factory()
            ->count(10)
            ->state([
                'created_at' => now()->subDays(15)
            ])->create();

        $this->assertDatabaseCount('server_stats', $countBefore + 10);

        // no entry should be deleted
        $this->artisan('prune:api-key')
            ->assertExitCode(1);
        $this->assertDatabaseCount('server_stats', $countBefore + 10);

        // no entry should be deleted
        $this->artisan('prune:api-key --maxAge=20')
            ->assertExitCode(1);
        $this->assertDatabaseCount('server_stats', $countBefore + 10);

        // 10 entries should be deleted now
        $this->artisan('prune:api-key --maxAge=14')
            ->assertExitCode(1);
        $this->assertDatabaseCount('server_stats', $countBefore);
    }
}
