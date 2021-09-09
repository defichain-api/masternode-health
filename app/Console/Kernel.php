<?php

namespace App\Console;

use App\Console\Commands\PruneDataCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

/**
 * @codeCoverageIgnore
 */
class Kernel extends ConsoleKernel
{
    protected $commands = [
        PruneDataCommand::class,
    ];

    protected function schedule(Schedule $schedule): void
    {
        $schedule->command(PruneDataCommand::class, ['--maxAge=14'])
            ->dailyAt('1:00');
    }

    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
