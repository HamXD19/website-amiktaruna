<?php

namespace App\Http\Middleware;

use App\Services\VisitorTracker;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackVisitorMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        return $next($request);
    }

    /**
     * Handle tasks after the response has been sent to the browser.
     * Terminable middleware runs with zero added latency to user page loads.
     */
    public function terminate(Request $request, Response $response): void
    {
        // Track only successful public GET visits (HTTP 200)
        if (
            $response->getStatusCode() === 200 &&
            $request->isMethod('GET') &&
            !$request->ajax() &&
            !$request->is('admin*') &&
            !$request->is('login*') &&
            !$request->is('logout*') &&
            !$request->is('register*') &&
            !$request->is('password*') &&
            !$request->is('api*') &&
            !$request->is('up') &&
            !$request->is('build*') &&
            !$request->is('uploads*') &&
            !$request->is('vendor*') &&
            !$request->is('favicon.ico') &&
            !$request->is('robots.txt')
        ) {
            try {
                VisitorTracker::track($request);
            } catch (\Throwable $e) {
                // Ignore tracking errors
            }
        }
    }
}
