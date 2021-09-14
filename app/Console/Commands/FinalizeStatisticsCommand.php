<?php

namespace App\Console\Commands;

use App\Models\Service\StatisticService;
use Illuminate\Console\Command;

class FinalizeStatisticsCommand extends Command
{
    protected $signature = 'statistic:finalize {--forLastDays=1}';
    protected $description = 'Count the api keys for the given date';

    public function handle(StatisticService $statisticService): int
    {
        $forLastDays = (int)$this->option('forLastDays');
        if ($forLastDays < 1 || !is_int($forLastDays)) {
            $this->error('the param "forLastDays" must be an integer >= 1');

            return 1;
        }

        for ($i = $forLastDays; $i > 0; $i--) {
            $date = today()->subDays($i);
            $statisticService->updateApiKeysForDate($date);
        }

        return 0;
    }
}
