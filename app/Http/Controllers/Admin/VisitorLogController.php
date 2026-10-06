<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VisitorLog;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class VisitorLogController extends Controller
{
    public function index(Request $request)
    {
        $period = $request->get('period', '7days');
        $device = $request->get('device', 'all');
        $country = $request->get('country', 'all');
        $search = $request->get('search');
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        // Base Query for Table Logs
        $query = VisitorLog::query();

        // Filter by Period
        match ($period) {
            'today'      => $query->whereDate('created_at', today()),
            'yesterday'  => $query->whereDate('created_at', today()->subDay()),
            '7days'      => $query->where('created_at', '>=', now()->subDays(7)),
            '30days'     => $query->where('created_at', '>=', now()->subDays(30)),
            'this_month' => $query->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year),
            'custom'     => $startDate && $endDate 
                ? $query->whereBetween('created_at', [
                    Carbon::parse($startDate)->startOfDay(), 
                    Carbon::parse($endDate)->endOfDay()
                  ]) 
                : $query,
            default      => $query,
        };

        // Filter by Device
        if ($device !== 'all') {
            if ($device === 'bot') {
                $query->where('is_bot', true);
            } else {
                $query->where('device', $device)->where('is_bot', false);
            }
        }

        // Filter by Country
        if ($country !== 'all') {
            $query->where('country_code', $country);
        }

        // Search Filter
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('ip_address', 'like', "%{$search}%")
                  ->orWhere('url', 'like', "%{$search}%")
                  ->orWhere('page_name', 'like', "%{$search}%")
                  ->orWhere('referrer', 'like', "%{$search}%")
                  ->orWhere('browser', 'like', "%{$search}%")
                  ->orWhere('platform', 'like', "%{$search}%")
                  ->orWhere('country', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%");
            });
        }

        // Summary Statistics (Human visits focused)
        $todayUnique = VisitorLog::human()->today()->distinct('session_id')->count('session_id');
        $todayHits   = VisitorLog::human()->today()->count();
        $onlineNow   = VisitorLog::human()->online(10)->distinct('session_id')->count('session_id');
        $weekUnique  = VisitorLog::human()->recent(7)->distinct('session_id')->count('session_id');
        $monthUnique = VisitorLog::human()->recent(30)->distinct('session_id')->count('session_id');
        $allTimeHits = VisitorLog::human()->count();
        $botHits     = VisitorLog::bot()->count();

        // 7-Day Chart Trend Data
        $chartDays = 7;
        $chartDates = [];
        $chartUnique = [];
        $chartHits = [];

        for ($i = $chartDays - 1; $i >= 0; $i--) {
            $date = today()->subDays($i);
            $dateStr = $date->format('Y-m-d');
            $label = $date->translatedFormat('d M');

            $chartDates[] = $label;
            $chartUnique[] = VisitorLog::human()
                ->whereDate('created_at', $dateStr)
                ->distinct('session_id')
                ->count('session_id');
            $chartHits[] = VisitorLog::human()
                ->whereDate('created_at', $dateStr)
                ->count();
        }

        // Top 10 Most Visited Pages
        $topPages = VisitorLog::human()
            ->select('page_name', 'url', DB::raw('count(*) as total_hits'), DB::raw('count(distinct session_id) as unique_visitors'))
            ->groupBy('page_name', 'url')
            ->orderByDesc('total_hits')
            ->limit(8)
            ->get();

        // Device Breakdown
        $deviceCounts = VisitorLog::human()
            ->select('device', DB::raw('count(*) as count'))
            ->groupBy('device')
            ->pluck('count', 'device')
            ->toArray();

        $totalDeviceHits = array_sum($deviceCounts) ?: 1;
        $deviceShare = [
            'mobile'  => round((($deviceCounts['mobile'] ?? 0) / $totalDeviceHits) * 100),
            'desktop' => round((($deviceCounts['desktop'] ?? 0) / $totalDeviceHits) * 100),
            'tablet'  => round((($deviceCounts['tablet'] ?? 0) / $totalDeviceHits) * 100),
        ];

        // Top Browsers
        $topBrowsers = VisitorLog::human()
            ->select('browser', DB::raw('count(*) as total'))
            ->groupBy('browser')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        // Top Referrers
        $topReferrers = VisitorLog::human()
            ->select('referrer_host', DB::raw('count(*) as total'))
            ->whereNotNull('referrer_host')
            ->groupBy('referrer_host')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        // Top Countries
        $topCountries = VisitorLog::human()
            ->select('country', 'country_code', DB::raw('count(*) as total'))
            ->whereNotNull('country')
            ->groupBy('country', 'country_code')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        // Available Countries for Filter Dropdown
        $availableCountries = VisitorLog::human()
            ->select('country', 'country_code')
            ->whereNotNull('country_code')
            ->whereNotNull('country')
            ->groupBy('country', 'country_code')
            ->orderBy('country')
            ->get();

        // Paginated Logs Table
        $logs = $query->latest('id')->paginate(25)->withQueryString();

        return view('admin.visitor_logs.index', compact(
            'logs',
            'period',
            'device',
            'country',
            'search',
            'startDate',
            'endDate',
            'todayUnique',
            'todayHits',
            'onlineNow',
            'weekUnique',
            'monthUnique',
            'allTimeHits',
            'botHits',
            'chartDates',
            'chartUnique',
            'chartHits',
            'topPages',
            'deviceShare',
            'deviceCounts',
            'topBrowsers',
            'topReferrers',
            'topCountries',
            'availableCountries'
        ));
    }

    /**
     * Export Logs to CSV
     */
    public function export(Request $request)
    {
        $fileName = 'log_pengunjung_amiktaruna_' . date('Y-m-d_His') . '.csv';

        $query = VisitorLog::query()->latest('id');

        if ($request->filled('period')) {
            match ($request->period) {
                'today'      => $query->whereDate('created_at', today()),
                '7days'      => $query->where('created_at', '>=', now()->subDays(7)),
                '30days'     => $query->where('created_at', '>=', now()->subDays(30)),
                'this_month' => $query->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year),
                default      => null,
            };
        }

        if ($request->filled('device') && $request->device !== 'all') {
            if ($request->device === 'bot') {
                $query->where('is_bot', true);
            } else {
                $query->where('device', $request->device)->where('is_bot', false);
            }
        }

        if ($request->filled('country') && $request->country !== 'all') {
            $query->where('country_code', $request->country);
        }

        $headers = [
            "Content-type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = [
            'ID',
            'Waktu Kunjungan (WIB)',
            'IP Address',
            'Halaman',
            'URL Lengkap',
            'Perangkat',
            'Sistem Operasi',
            'Browser',
            'Negara',
            'Kode Negara',
            'Kota',
            'Sumber (Referrer)',
            'Tipe Pengunjung',
            'ID Sesi',
        ];

        $callback = function () use ($query, $columns) {
            $file = fopen('php://output', 'w');
            // Add UTF-8 BOM for Indonesian Excel compatibility
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            fputcsv($file, $columns);

            $query->chunk(500, function ($logs) use ($file) {
                foreach ($logs as $log) {
                    fputcsv($file, [
                        $log->id,
                        $log->created_at->format('d/m/Y H:i:s'),
                        $log->ip_address,
                        $log->page_name,
                        $log->url,
                        ucfirst($log->device),
                        $log->platform,
                        $log->browser,
                        $log->country ?? '-',
                        $log->country_code ?? '-',
                        $log->city ?? '-',
                        $log->referrer_host ?: ($log->referrer ?: 'Langsung (Direct)'),
                        $log->is_bot ? 'Robot / Crawler' : 'Pengguna (Human)',
                        $log->session_id,
                    ]);
                }
            });

            fclose($file);
        };

        ActivityLogger::log('EXPORT', 'VisitorLog', 'Mengekspor log pengunjung ke CSV');

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Clear old logs to save disk storage
     */
    public function clear(Request $request)
    {
        $request->validate([
            'mode' => 'required|string|in:30days,60days,90days,bot_only,all',
        ]);

        $mode = $request->mode;
        $count = 0;

        if ($mode === '30days') {
            $count = VisitorLog::where('created_at', '<', now()->subDays(30))->delete();
            $msg = "Berhasil menghapus {$count} log pengunjung yang lebih dari 30 hari.";
        } elseif ($mode === '60days') {
            $count = VisitorLog::where('created_at', '<', now()->subDays(60))->delete();
            $msg = "Berhasil menghapus {$count} log pengunjung yang lebih dari 60 hari.";
        } elseif ($mode === '90days') {
            $count = VisitorLog::where('created_at', '<', now()->subDays(90))->delete();
            $msg = "Berhasil menghapus {$count} log pengunjung yang lebih dari 90 hari.";
        } elseif ($mode === 'bot_only') {
            $count = VisitorLog::where('is_bot', true)->delete();
            $msg = "Berhasil menghapus {$count} log kunjungan bot / robot crawler.";
        } elseif ($mode === 'all') {
            if (!auth()->user()->isSuperAdmin()) {
                return back()->with('error', 'Hanya Super Admin yang berhak menghapus seluruh log pengunjung.');
            }
            $count = VisitorLog::count();
            VisitorLog::truncate();
            $msg = "Seluruh log pengunjung ({$count} data) berhasil direset/dikosongkan.";
        }

        ActivityLogger::log('DELETE', 'VisitorLog', "Membersihkan log pengunjung ({$mode}): {$count} baris dihapus");

        return back()->with('success', $msg);
    }
}
