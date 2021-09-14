<?php

namespace App\Repository;

use App\Models\Statistic;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class StatisticRepository
{
    public static function lastWeek(): Collection
    {
        return Statistic::whereDate('date', '<', today())
            ->whereDate('date', '>=', today()->subWeek())
            ->orderByDesc('date')
            ->get();
    }

    public static function getAll(): LengthAwarePaginator
    {
        return Statistic::whereDate('date', '<', today())
            ->orderByDesc('date')
            ->paginate(25);
    }
}
