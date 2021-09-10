<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Middleware\ThrottleRequests as ThrottleRequestsLaravel;
use RuntimeException;

/**
 * @codeCoverageIgnore
 */
class ApiThrottleRequests extends ThrottleRequestsLaravel
{
    public function handle($request, Closure $next, $maxAttempts = 60, $decayMinutes = 1, $prefix = '')
    {
        $key = $this->resolveRequestSignature($request);
        /** @var \App\Models\ApiKey $apiKey */
        $apiKey = $request->get('api_key');

        if ((isset($apiKey->throttle_disabled) && !$apiKey->throttle_disabled) && $this->limiter->tooManyAttempts($key,
            $maxAttempts)) {
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
            return sha1(sprintf('%s|%s', $route->uri, $request->ip()));
        }

        throw new RuntimeException('Unable to generate the request signature. Route unavailable.');
    }
}
