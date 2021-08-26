<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Middleware\ThrottleRequests as ThrottleRequestsLaravel;
use RuntimeException;

class ApiThrottleRequests extends ThrottleRequestsLaravel
{
    public function handle($request, Closure $next, $maxAttempts = 60, $decayMinutes = 1, $prefix = '')
    {
        $key = $this->resolveRequestSignature($request);
        ray($key);
        if ($this->limiter->tooManyAttempts($key, $maxAttempts, $decayMinutes)) {
            return $this->buildJsonResponse($key, $maxAttempts, $decayMinutes);
        }

        $this->limiter->hit($key, $decayMinutes);

        $response = $next($request);

        return $this->addHeaders(
            $response, $maxAttempts,
            $this->calculateRemainingAttempts($key, $maxAttempts)
        );
    }

    protected function buildJsonResponse(string $key, int $maxAttempts, int $decayMinutes)
    {
        ray($key);
        $retryAfter = $this->limiter->availableIn($key);
        $response = new JsonResponse([
            'error' => [
                'code'    => 429,
                'message' => sprintf(
                    'Too Many Attempts. Only %s requests are allowed every %s seconds. After %s seconds you can access this endpoint again.',
                    $maxAttempts,
                    $decayMinutes,
                    $retryAfter
                ),
            ],
        ], 429);

        return $this->addHeaders(
            $response,
            $maxAttempts,
            $this->calculateRemainingAttempts($key, $maxAttempts, $retryAfter),
            $retryAfter
        );
    }

    protected function resolveRequestSignature($request)
    {
        if ($route = $request->route()) {
        ray($route->uri);
            return sha1(sprintf('%s|%s', $route->uri, $request->ip()));
        }

        throw new RuntimeException('Unable to generate the request signature. Route unavailable.');
    }
}
