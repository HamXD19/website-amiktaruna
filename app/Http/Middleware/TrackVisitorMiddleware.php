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
        $response = $next($request);

        // Track only successful public GET visits
        if (
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
            VisitorTracker::track($request);
        }

        return $response;
    }
}
