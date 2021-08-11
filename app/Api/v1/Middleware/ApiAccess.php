<?php

namespace App\Api\v1\Middleware;

use App\Models\ApiKey;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiAccess
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $apiKey = $request->header('x-api-key', null);
        $apiKey = ApiKey::where('id', $apiKey)
            ->first();

        if (is_null($apiKey)) {
            return response()->json([
                'state'  => 'error',
                'reason' => 'not authorized',
            ], JsonResponse::HTTP_UNAUTHORIZED);
        }
        $request->merge([
            'api_key' => $apiKey,
        ]);

        return $next($request);
    }
}
