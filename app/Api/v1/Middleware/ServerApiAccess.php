<?php

namespace App\Api\v1\Middleware;

use App\Models\Server;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ServerApiAccess
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $serverId = $request->header('x-server-key', null);
        $apiKey = $request->header('x-api-key', null);
        $server = Server::where('id', $serverId)
            ->whereHas('apiKey', function ($query) use ($apiKey) {
                $query->where('id', $apiKey);
            })->first();
ray($serverId, $apiKey);
        if (is_null($server)) {
            return response()->json([
                'state'  => 'error',
                'reason' => 'not authorized',
            ], JsonResponse::HTTP_UNAUTHORIZED);
        }
        $request->merge([
            'server'  => $server,
            'api_key' => $apiKey,
        ]);

        return $next($request);
    }
}
