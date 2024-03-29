<?php

namespace App\Api\v1\Middleware;

use Closure;
use Illuminate\Http\Request;

class PaginateAPI
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        $data = $response->getData(true);

        if (isset($data['meta']['links'])) {
            unset($data['meta']['links']);
        }

        $response->setData($data);

        return $response;
    }
}
