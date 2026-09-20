<?php

namespace App\Services;

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

/**
 * A thin client for Statamic's read-only Content REST API
 * (https://statamic.dev/frontend/rest-api).
 *
 * Requests are dispatched *in-process* through Laravel's HTTP kernel rather
 * than over a real network socket. Blog controllers still consume exactly
 * the same JSON contract any external API client would get (so the
 * frontend stays decoupled from Statamic's PHP API), but without the risk
 * of a self-referential network call deadlocking under a single-threaded
 * server such as `php artisan serve`.
 */
class StatamicApiClient
{
    protected string $prefix;

    public function __construct()
    {
        $this->prefix = '/'.trim((string) config('statamic.api.route', 'api'), '/');
    }

    /**
     * "Request" a Statamic REST API endpoint and return the decoded JSON
     * body. Returns an empty `data` payload on failure so callers can
     * render an empty state instead of crashing the page.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function get(string $path, array $query = []): array
    {
        $uri = $this->prefix.'/'.ltrim($path, '/');

        $request = Request::create($uri, 'GET', $query, [], [], [
            'HTTP_ACCEPT' => 'application/json',
        ]);

        try {
            $kernel = app(Kernel::class);
            $response = $kernel->handle($request);
            $kernel->terminate($request, $response);
        } catch (Throwable $e) {
            Log::warning('Statamic API request could not be completed.', [
                'uri' => $uri,
                'message' => $e->getMessage(),
            ]);

            return ['data' => []];
        }

        if ($response->getStatusCode() >= 400) {
            Log::warning('Statamic API request failed.', [
                'uri' => $uri,
                'query' => $query,
                'status' => $response->getStatusCode(),
            ]);

            return ['data' => []];
        }

        return json_decode($response->getContent() ?: '', true) ?? ['data' => []];
    }
}
