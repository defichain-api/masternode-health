<?php

namespace App\Repository;

use App\Models\Statistic;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class StatisticRepository
{
    const MAX_PER_PAGE = 25;
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
            ->paginate(self::MAX_PER_PAGE);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Query\Builder|object|null
     */
    public static function today()
    {
        return Statistic::whereDate('date', '=', today())
            ->first();
    }
}
