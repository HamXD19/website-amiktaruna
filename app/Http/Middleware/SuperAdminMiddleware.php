<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\ActivityLogger;
use Symfony\Component\HttpFoundation\Response;

class SuperAdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (!$user || !$user->isSuperAdmin()) {
            ActivityLogger::log(
                'SECURITY',
                'Hak Akses',
                'Percobaan akses ke area khusus Super Admin ditolak pada URL: ' . $request->path()
            );

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Akses ditolak. Halaman ini hanya dapat diakses oleh Super Admin.'
                ], 403);
            }

            return redirect()->route('admin.dashboard')->with('error', 'Akses ditolak! Menu tersebut hanya dapat diakses oleh Super Admin.');
        }

        return $next($request);
    }
}
