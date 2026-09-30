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

        // Implied permissions: 'kategori' is automatically granted to users
        // who have access to any module that uses categories (berita, lppm, ppm, etc.)
        if ($menuKey === 'kategori') {
            $relatedMenus = ['berita', 'beritapmb', 'lppm', 'ppm', 'dokumen_kampus', 'program_studi', 'kategori'];
            $hasRelated = false;
            foreach ($relatedMenus as $related) {
                if ($user->hasPermission($related)) {
                    $hasRelated = true;
                    break;
                }
            }
            if ($hasRelated) {
                return $next($request);
            }
        }

        // Implied permissions: 'dokumen_kampus' automatically accessible if user has ppm, lppm, setting, or visimisi
        if ($menuKey === 'dokumen_kampus') {
            $relatedMenus = ['dokumen_kampus', 'ppm', 'lppm', 'setting', 'visimisi'];
            $hasRelated = false;
            foreach ($relatedMenus as $related) {
                if ($user->hasPermission($related)) {
                    $hasRelated = true;
                    break;
                }
            }
            if ($hasRelated) {
                return $next($request);
            }
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
