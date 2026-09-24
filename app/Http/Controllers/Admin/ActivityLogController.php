<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\User;
use App\Services\ActivityLogger;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    /**
     * Display a listing of activity logs.
     */
    public function index(Request $request)
    {
        $query = ActivityLog::query();

        // Keyword search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                  ->orWhere('user_name', 'like', "%{$search}%")
                  ->orWhere('ip_address', 'like', "%{$search}%");
            });
        }

        // Action filter
        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        // Module filter
        if ($request->filled('module')) {
            $query->where('module', $request->module);
        }

        // User filter
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Date range filter
        if ($request->filled('date_range')) {
            switch ($request->date_range) {
                case 'today':
                    $query->whereDate('created_at', Carbon::today());
                    break;
                case '7_days':
                    $query->where('created_at', '>=', Carbon::now()->subDays(7));
                    break;
                case '30_days':
                    $query->where('created_at', '>=', Carbon::now()->subDays(30));
                    break;
            }
        }

        $logs = $query->latest('id')->paginate(25)->withQueryString();

        // Statistics
        $today = Carbon::today();
        $stats = [
            'total' => ActivityLog::count(),
            'today_count' => ActivityLog::whereDate('created_at', $today)->count(),
            'mutations_count' => ActivityLog::whereIn('action', ['CREATE', 'UPDATE', 'DELETE'])->count(),
            'security_count' => ActivityLog::where('action', 'SECURITY')->count(),
        ];

        $modules = ActivityLog::select('module')->distinct()->whereNotNull('module')->pluck('module');
        $users = User::select('id', 'name', 'role')->get();

        return view('admin.activity_logs.index', compact('logs', 'stats', 'modules', 'users'));
    }

    /**
     * Clear logs based on retention option.
     */
    public function clear(Request $request)
    {
        $request->validate([
            'retention' => 'required|in:30_days,60_days,all',
        ]);

        $deletedCount = 0;
        if ($request->retention === '30_days') {
            $cutoff = Carbon::now()->subDays(30);
            $deletedCount = ActivityLog::where('created_at', '<', $cutoff)->delete();
            $msg = "Berhasil menghapus {$deletedCount} catatan log yang berusia lebih dari 30 hari.";
        } elseif ($request->retention === '60_days') {
            $cutoff = Carbon::now()->subDays(60);
            $deletedCount = ActivityLog::where('created_at', '<', $cutoff)->delete();
            $msg = "Berhasil menghapus {$deletedCount} catatan log yang berusia lebih dari 60 hari.";
        } elseif ($request->retention === 'all') {
            $deletedCount = ActivityLog::count();
            ActivityLog::truncate();
            $msg = "Seluruh log aktivitas ({$deletedCount} baris) berhasil dibersihkan.";
        }

        ActivityLogger::log('DELETE', 'Log Aktivitas', "Super Admin membersihkan riwayat log ({$msg})");

        return redirect()->route('admin.activity-logs.index')->with('success', $msg);
    }
}
