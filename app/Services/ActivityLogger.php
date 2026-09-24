<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ActivityLogger
{
    /**
     * Record an activity log entry.
     *
     * @param string $action LOGIN, LOGOUT, CREATE, UPDATE, DELETE, SECURITY
     * @param string $module Module name (e.g., Berita, PMB, Manajemen Pengguna)
     * @param string|null $description Detailed description of the action
     * @param mixed $user Optional User instance
     * @return ActivityLog|null
     */
    public static function log(string $action, string $module, ?string $description = null, $user = null): ?ActivityLog
    {
        try {
            $currentUser = $user ?? Auth::user();

            return ActivityLog::create([
                'user_id' => $currentUser?->id,
                'user_name' => $currentUser?->name ?? 'Sistem / Tamu',
                'user_role' => $currentUser?->role ?? ($currentUser ? 'admin' : 'guest'),
                'action' => strtoupper($action),
                'module' => $module,
                'description' => $description,
                'ip_address' => Request::ip() ?? '127.0.0.1',
                'user_agent' => substr((string) Request::userAgent(), 0, 500),
            ]);
        } catch (\Throwable $e) {
            // Never break application execution if logging fails
            \Illuminate\Support\Facades\Log::warning('ActivityLogger failed: ' . $e->getMessage());
            return null;
        }
    }
}
