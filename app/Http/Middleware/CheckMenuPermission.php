<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\ActivityLogger;
use Symfony\Component\HttpFoundation\Response;

class CheckMenuPermission
{
    /**
     * Handle an incoming request.
     *
     * @param string $menuKey
     */
    public function handle(Request $request, Closure $next, string $menuKey): Response
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Super Admin has unrestricted access to all menus
        if ($user->isSuperAdmin()) {
            return $next($request);
        }

        // Check if menu is in user permissions
        if (!$user->hasPermission($menuKey)) {
            ActivityLogger::log(
                'SECURITY',
                'Hak Akses Menu',
                "Percobaan akses ke menu '$menuKey' ditolak pada URL: " . $request->path()
            );

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Anda tidak memiliki hak akses untuk menu ini.'
                ], 403);
            }

            return redirect()->route('admin.dashboard')->with('error', 'Akses dibatasi! Anda tidak memiliki izin untuk mengakses menu tersebut.');
        }

        return $next($request);
    }
}
