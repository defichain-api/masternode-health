<?php

namespace App\Api\v1\Middleware;

use App\Models\Service\StatisticService;
use Closure;
use Illuminate\Http\Request;

class RequestReceived
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        app(StatisticService::class)->requestReceived();

        return $next($request);
    }
}
