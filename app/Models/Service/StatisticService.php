<?php

namespace App\Models\Service;

use App\Models\ApiKey;
use App\Models\Statistic;
use Carbon\Carbon;
use DB;

class StatisticService
{
    public function webhookSent(): void
    {
        Statistic::updateOrCreate([
            'date' => today(),
        ], [
            'webhook_sent_count' => DB::raw('webhook_sent_count + 1'),
        ]);
    }

    public function requestReceived(): void
    {
        Statistic::updateOrCreate([
            'date' => today(),
        ], [
            'request_received_count' => DB::raw('request_received_count + 1'),
        ]);
    }

    public function updateApiKeysForDate(Carbon $date = null): self
    {
        $date = $date ?? today();
        Statistic::updateOrCreate([
            'date' => $date,
        ], [
            'api_key_count' => ApiKey::all()->count(),
        ]);

        return $this;
    }
}
