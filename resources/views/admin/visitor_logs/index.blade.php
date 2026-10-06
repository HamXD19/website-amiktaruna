@extends('layouts.app')

@section('title', 'Log Pengunjung & Analitik Trafik')

@section('content')
<div class="container-fluid px-0">

    <!-- Header & Breadcrumb -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
        <div>
            <div class="d-flex align-items-center gap-2 text-muted small mb-1">
                <a href="{{ route('admin.dashboard') }}" class="text-decoration-none text-muted">Dashboard</a>
                <span>&bull;</span>
                <span class="text-emerald-700 fw-semibold">Profil &amp; Konfigurasi</span>
                <span>&bull;</span>
                <span class="text-emerald-700 fw-semibold">Log Pengunjung</span>
            </div>
            <h1 class="h3 fw-bold text-slate-800 mb-0 d-flex align-items-center gap-2">
                <span>Log Pengunjung &amp; Analitik Trafik</span>
                <span class="badge bg-emerald-500/10 text-emerald-700 border border-emerald-500/30 fs-xs py-1 px-2.5 rounded-pill font-monospace">
                    <i class="fas fa-chart-line me-1"></i>Live Tracking
                </span>
            </h1>
            <p class="text-muted small mb-0 mt-1">
                Statistik lalu lintas kunjungan web publik AMIK Taruna, deteksi perangkat, sistem operasi, browser, dan sumber rujukan pengunjung.
            </p>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('admin.visitor-logs.export', request()->all()) }}" class="btn btn-outline-success d-inline-flex align-items-center gap-2 rounded-3 px-3 py-2 shadow-sm bg-white">
                <i class="fas fa-file-excel text-emerald-600"></i>
                <span class="small fw-semibold">Export CSV / Excel</span>
            </a>
            <button type="button" class="btn btn-outline-danger d-inline-flex align-items-center gap-2 rounded-3 px-3 py-2 shadow-sm bg-white" data-bs-toggle="modal" data-bs-target="#clearVisitorLogModal">
                <i class="fas fa-trash-can"></i>
                <span class="small fw-semibold">Bersihkan Log</span>
            </button>
        </div>
    </div>

    <!-- Flash Notifications -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm border-0 d-flex align-items-center gap-3 p-3 mb-4" role="alert">
            <i class="fas fa-circle-check fs-4 text-success"></i>
            <div class="small fw-semibold">{{ session('success') }}</div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm border-0 d-flex align-items-center gap-3 p-3 mb-4" role="alert">
            <i class="fas fa-circle-exclamation fs-4 text-danger"></i>
            <div class="small fw-semibold">{{ session('error') }}</div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- 1. Stat Cards Row -->
    <div class="row g-3 mb-4">
        <!-- Hari Ini -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 rounded-4 shadow-sm h-100 bg-white p-3.5 border-start border-4 border-emerald-500">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small fw-bold text-uppercase tracking-wider">Hari Ini</span>
                    <div class="w-10 h-10 rounded-3 d-flex align-items-center justify-content-center bg-emerald-50 text-emerald-600">
                        <i class="fas fa-users fs-5"></i>
                    </div>
                </div>
                <div class="d-flex align-items-baseline gap-2">
                    <span class="h3 fw-bolder text-emerald-700 mb-0">{{ number_format($todayUnique) }}</span>
                    <span class="text-xs text-muted fw-semibold">pengunjung unik</span>
                </div>
                <div class="text-xs text-muted mt-2 d-flex align-items-center gap-1.5 pt-2 border-top border-slate-100">
                    <i class="fas fa-eye text-emerald-500"></i>
                    <span><strong>{{ number_format($todayHits) }}</strong> total tayangan (pageviews)</span>
                </div>
            </div>
        </div>

        <!-- Online Sekarang -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 rounded-4 shadow-sm h-100 bg-white p-3.5 border-start border-4 border-cyan-500">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small fw-bold text-uppercase tracking-wider">Online Sekarang</span>
                    <div class="w-10 h-10 rounded-3 d-flex align-items-center justify-content-center bg-cyan-50 text-cyan-600 position-relative">
                        <i class="fas fa-signal fs-5"></i>
                        <span class="position-absolute top-1 end-1 p-1 bg-success border border-white rounded-circle animate-ping" style="width: 8px; height: 8px;"></span>
                    </div>
                </div>
                <div class="d-flex align-items-baseline gap-2">
                    <span class="h3 fw-bolder text-cyan-700 mb-0">{{ number_format($onlineNow) }}</span>
                    <span class="text-xs text-muted fw-semibold">aktif</span>
                </div>
                <div class="text-xs text-muted mt-2 d-flex align-items-center gap-1.5 pt-2 border-top border-slate-100">
                    <i class="fas fa-clock text-cyan-500"></i>
                    <span>Aktivitas dalam 10 menit terakhir</span>
                </div>
            </div>
        </div>

        <!-- Unik 7 Hari & 30 Hari -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 rounded-4 shadow-sm h-100 bg-white p-3.5 border-start border-4 border-indigo-500">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small fw-bold text-uppercase tracking-wider">7 Hari Terakhir</span>
                    <div class="w-10 h-10 rounded-3 d-flex align-items-center justify-content-center bg-indigo-50 text-indigo-600">
                        <i class="fas fa-chart-simple fs-5"></i>
                    </div>
                </div>
                <div class="d-flex align-items-baseline gap-2">
                    <span class="h3 fw-bolder text-indigo-700 mb-0">{{ number_format($weekUnique) }}</span>
                    <span class="text-xs text-muted fw-semibold">pengunjung unik</span>
                </div>
                <div class="text-xs text-muted mt-2 d-flex align-items-center gap-1.5 pt-2 border-top border-slate-100">
                    <i class="fas fa-calendar-alt text-indigo-500"></i>
                    <span><strong>{{ number_format($monthUnique) }}</strong> unik dalam 30 hari</span>
                </div>
            </div>
        </div>

        <!-- Total Pageviews & Bot -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 rounded-4 shadow-sm h-100 bg-white p-3.5 border-start border-4 border-amber-500">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small fw-bold text-uppercase tracking-wider">Total Tayangan</span>
                    <div class="w-10 h-10 rounded-3 d-flex align-items-center justify-content-center bg-amber-50 text-amber-600">
                        <i class="fas fa-globe fs-5"></i>
                    </div>
                </div>
                <div class="d-flex align-items-baseline gap-2">
                    <span class="h3 fw-bolder text-slate-800 mb-0">{{ number_format($allTimeHits) }}</span>
                    <span class="text-xs text-muted fw-semibold">semua waktu</span>
                </div>
                <div class="text-xs text-muted mt-2 d-flex align-items-center gap-1.5 pt-2 border-top border-slate-100">
                    <i class="fas fa-robot text-amber-600"></i>
                    <span>Bot / Mesin Pencari: <strong>{{ number_format($botHits) }}</strong></span>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. Charts & Device Share Row -->
    <div class="row g-3 mb-4">
        <!-- 7-Day Trend Chart -->
        <div class="col-12 col-lg-8">
            <div class="card border-0 rounded-4 shadow-sm h-100 bg-white p-4">
                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-2 mb-3">
                    <div>
                        <h6 class="fw-bold text-slate-800 mb-0 d-flex align-items-center gap-2">
                            <i class="fas fa-chart-area text-emerald-600"></i>
                            Tren Pengunjung 7 Hari Terakhir
                        </h6>
                        <small class="text-muted">Perbandingan Pengunjung Unik dan Total Pageviews</small>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <div class="d-flex align-items-center gap-1.5 small text-muted">
                            <span class="d-inline-block rounded-circle bg-emerald-500" style="width: 10px; height: 10px;"></span>
                            <span class="fw-semibold">Unik</span>
                        </div>
                        <div class="d-flex align-items-center gap-1.5 small text-muted">
                            <span class="d-inline-block rounded-circle bg-cyan-500" style="width: 10px; height: 10px;"></span>
                            <span class="fw-semibold">Pageviews</span>
                        </div>
                    </div>
                </div>
                <div style="position: relative; height: 260px; width: 100%;">
                    <canvas id="visitorTrendChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Device Share -->
        <div class="col-12 col-lg-4">
            <div class="card border-0 rounded-4 shadow-sm h-100 bg-white p-4 d-flex flex-column justify-content-between">
                <div>
                    <h6 class="fw-bold text-slate-800 mb-1 d-flex align-items-center gap-2">
                        <i class="fas fa-mobile-screen-button text-emerald-600"></i>
                        Perangkat Pengunjung
                    </h6>
                    <small class="text-muted mb-3 d-block">Distribusi pengguna berdasarkan perangkat</small>

                    <!-- Mobile -->
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center small mb-1.5">
                            <span class="fw-semibold text-slate-700 d-flex align-items-center gap-2">
                                <i class="fas fa-mobile-screen text-emerald-600"></i>
                                Smartphone / Mobile
                            </span>
                            <span class="fw-bold text-emerald-700">{{ $deviceShare['mobile'] }}% <span class="text-muted fw-normal">({{ number_format($deviceCounts['mobile'] ?? 0) }})</span></span>
                        </div>
                        <div class="progress" style="height: 8px; border-radius: 999px; background-color: #f1f5f9;">
                            <div class="progress-bar bg-emerald-500 rounded-pill" role="progressbar" style="width: {{ $deviceShare['mobile'] }}%;" aria-valuenow="{{ $deviceShare['mobile'] }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>

                    <!-- Desktop -->
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center small mb-1.5">
                            <span class="fw-semibold text-slate-700 d-flex align-items-center gap-2">
                                <i class="fas fa-laptop text-cyan-600"></i>
                                Komputer / Desktop
                            </span>
                            <span class="fw-bold text-cyan-700">{{ $deviceShare['desktop'] }}% <span class="text-muted fw-normal">({{ number_format($deviceCounts['desktop'] ?? 0) }})</span></span>
                        </div>
                        <div class="progress" style="height: 8px; border-radius: 999px; background-color: #f1f5f9;">
                            <div class="progress-bar bg-cyan-500 rounded-pill" role="progressbar" style="width: {{ $deviceShare['desktop'] }}%;" aria-valuenow="{{ $deviceShare['desktop'] }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>

                    <!-- Tablet -->
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center small mb-1.5">
                            <span class="fw-semibold text-slate-700 d-flex align-items-center gap-2">
                                <i class="fas fa-tablet-screen-button text-indigo-600"></i>
                                Tablet
                            </span>
                            <span class="fw-bold text-indigo-700">{{ $deviceShare['tablet'] }}% <span class="text-muted fw-normal">({{ number_format($deviceCounts['tablet'] ?? 0) }})</span></span>
                        </div>
                        <div class="progress" style="height: 8px; border-radius: 999px; background-color: #f1f5f9;">
                            <div class="progress-bar bg-indigo-500 rounded-pill" role="progressbar" style="width: {{ $deviceShare['tablet'] }}%;" aria-valuenow="{{ $deviceShare['tablet'] }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>

                <div class="p-2.5 rounded-3 bg-slate-50 border border-slate-100 text-xs text-muted d-flex align-items-center gap-2 mt-2">
                    <i class="fas fa-circle-info text-emerald-600"></i>
                    <span>Trafik mobile didominasi pengguna smartphone Android &amp; iOS.</span>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. Top Pages & Browsers Row -->
    <div class="row g-3 mb-4">
        <!-- Top Pages -->
        <div class="col-12 col-lg-7">
            <div class="card border-0 rounded-4 shadow-sm h-100 bg-white p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold text-slate-800 mb-0 d-flex align-items-center gap-2">
                        <i class="fas fa-fire text-amber-500"></i>
                        Halaman Paling Sering Dikunjungi
                    </h6>
                    <span class="badge bg-slate-100 text-slate-600 rounded-pill px-2.5 py-1 text-xs">Top 8</span>
                </div>
                
                @if($topPages->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm align-middle mb-0">
                            <thead>
                                <tr class="text-muted text-xs text-uppercase tracking-wider border-bottom">
                                    <th style="width: 35px;">#</th>
                                    <th>Halaman / URL</th>
                                    <th class="text-end" style="width: 90px;">Tayangan</th>
                                    <th class="text-end" style="width: 90px;">Unik</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($topPages as $idx => $p)
                                    <tr>
                                        <td class="text-muted text-xs fw-bold">{{ $idx + 1 }}</td>
                                        <td>
                                            <div class="fw-semibold text-slate-800 text-truncate" style="max-width: 320px;" title="{{ $p->page_name }}">
                                                {{ $p->page_name }}
                                            </div>
                                            <a href="{{ $p->url }}" target="_blank" class="text-xs text-muted text-decoration-none text-truncate d-block" style="max-width: 320px;" title="{{ $p->url }}">
                                                <i class="fas fa-external-link-alt me-1 text-slate-400" style="font-size: 9px;"></i>{{ parse_url($p->url, PHP_URL_PATH) ?: '/' }}
                                            </a>
                                        </td>
                                        <td class="text-end fw-bold text-emerald-700 font-monospace text-xs">
                                            {{ number_format($p->total_hits) }}
                                        </td>
                                        <td class="text-end text-muted font-monospace text-xs">
                                            {{ number_format($p->unique_visitors) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4 text-muted small">
                        <i class="fas fa-chart-simple fs-3 mb-2 d-block text-slate-300"></i>
                        Belum ada rekaman statistik halaman.
                    </div>
                @endif
            </div>
        </div>

        <!-- Top Browsers & Referrers -->
        <div class="col-12 col-lg-5">
            <div class="card border-0 rounded-4 shadow-sm h-100 bg-white p-4">
                <!-- Browsers -->
                <h6 class="fw-bold text-slate-800 mb-2.5 d-flex align-items-center gap-2">
                    <i class="fab fa-chrome text-cyan-600"></i>
                    Browser Terbanyak
                </h6>
                <div class="d-flex flex-wrap gap-2 mb-4">
                    @forelse($topBrowsers as $b)
                        <div class="d-flex align-items-center gap-2 px-2.5 py-1.5 rounded-3 bg-slate-50 border border-slate-100 text-xs">
                            <i class="fas fa-window-maximize text-emerald-600"></i>
                            <span class="fw-semibold text-slate-700">{{ $b->browser }}</span>
                            <span class="badge bg-emerald-100 text-emerald-800 rounded-pill font-monospace">{{ number_format($b->total) }}</span>
                        </div>
                    @empty
                        <span class="text-muted text-xs">Belum ada data browser</span>
                    @endforelse
                </div>

                <!-- Referrers -->
                <h6 class="fw-bold text-slate-800 mb-2.5 d-flex align-items-center gap-2">
                    <i class="fas fa-route text-indigo-600"></i>
                    Sumber Rujukan (Referrer)
                </h6>
                <div class="d-flex flex-column gap-2">
                    @forelse($topReferrers as $ref)
                        <div class="d-flex justify-content-between align-items-center px-2.5 py-1.5 rounded-3 bg-slate-50 border border-slate-100 text-xs">
                            <span class="text-slate-700 fw-semibold text-truncate d-flex align-items-center gap-2" style="max-width: 200px;">
                                <i class="fas fa-link text-slate-400"></i>
                                {{ $ref->referrer_host }}
                            </span>
                            <span class="badge bg-indigo-100 text-indigo-800 rounded-pill font-monospace">{{ number_format($ref->total) }} kunjungan</span>
                        </div>
                    @empty
                        <div class="text-muted text-xs py-2">
                            Mayoritas kunjungan langsung (Direct Traffic).
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- 4. Filter & Search Controls -->
    <div class="card border-0 rounded-4 shadow-sm bg-white p-3.5 mb-4">
        <form method="GET" action="{{ route('admin.visitor-logs.index') }}" class="row g-2.5 align-items-center">
            
            <!-- Search -->
            <div class="col-12 col-md-4">
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-white border-end-0 text-muted">
                        <i class="fas fa-magnifying-glass"></i>
                    </span>
                    <input type="text" name="search" value="{{ $search }}" class="form-control border-start-0 ps-0" placeholder="Cari IP, Halaman, Browser, OS, Referrer...">
                </div>
            </div>

            <!-- Periode Dropdown -->
            <div class="col-6 col-md-2">
                <select name="period" class="form-select form-select-sm text-xs">
                    <option value="7days" {{ $period === '7days' ? 'selected' : '' }}>7 Hari Terakhir</option>
                    <option value="today" {{ $period === 'today' ? 'selected' : '' }}>Hari Ini</option>
                    <option value="yesterday" {{ $period === 'yesterday' ? 'selected' : '' }}>Kemarin</option>
                    <option value="30days" {{ $period === '30days' ? 'selected' : '' }}>30 Hari Terakhir</option>
                    <option value="this_month" {{ $period === 'this_month' ? 'selected' : '' }}>Bulan Ini</option>
                    <option value="all" {{ $period === 'all' ? 'selected' : '' }}>Semua Waktu</option>
                </select>
            </div>

            <!-- Device Dropdown -->
            <div class="col-6 col-md-2">
                <select name="device" class="form-select form-select-sm text-xs">
                    <option value="all" {{ $device === 'all' ? 'selected' : '' }}>Semua Perangkat</option>
                    <option value="desktop" {{ $device === 'desktop' ? 'selected' : '' }}>Desktop (PC/Laptop)</option>
                    <option value="mobile" {{ $device === 'mobile' ? 'selected' : '' }}>Mobile (HP)</option>
                    <option value="tablet" {{ $device === 'tablet' ? 'selected' : '' }}>Tablet</option>
                    <option value="bot" {{ $device === 'bot' ? 'selected' : '' }}>Bot / Crawler</option>
                </select>
            </div>

            <!-- Actions -->
            <div class="col-12 col-md-4 d-flex gap-2 justify-content-md-end">
                <button type="submit" class="btn btn-sm btn-emerald text-white rounded-3 px-3 fw-semibold">
                    <i class="fas fa-filter me-1"></i>Terapkan Filter
                </button>
                @if($search || $period !== '7days' || $device !== 'all')
                    <a href="{{ route('admin.visitor-logs.index') }}" class="btn btn-sm btn-outline-secondary rounded-3 px-2.5" title="Reset Filter">
                        <i class="fas fa-rotate-left"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- 5. Interactive Table Logs -->
    <div class="card border-0 rounded-4 shadow-sm bg-white overflow-hidden mb-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-slate-50 border-bottom border-slate-100">
                    <tr class="text-xs text-uppercase tracking-wider text-muted font-monospace">
                        <th class="ps-4 py-3" style="width: 140px;">Waktu</th>
                        <th style="min-width: 150px;">Pengunjung / IP</th>
                        <th style="min-width: 200px;">Halaman Dikunjungi</th>
                        <th style="min-width: 140px;">Perangkat &amp; OS</th>
                        <th style="min-width: 130px;">Browser</th>
                        <th class="pe-4" style="min-width: 140px;">Sumber (Referrer)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($logs as $log)
                        <tr>
                            <!-- Waktu -->
                            <td class="ps-4">
                                <div class="fw-semibold text-slate-800 text-xs">{{ $log->created_at->diffForHumans() }}</div>
                                <div class="text-xs text-muted font-monospace" title="{{ $log->created_at->format('Y-m-d H:i:s') }}">
                                    {{ $log->created_at->format('d M H:i:s') }}
                                </div>
                            </td>

                            <!-- IP & Bot/Human -->
                            <td>
                                <div class="d-flex align-items-center gap-1.5">
                                    <span class="font-monospace fw-bold text-xs text-slate-700">{{ $log->ip_address }}</span>
                                    @if($log->is_bot)
                                        <span class="badge bg-amber-100 text-amber-800 border border-amber-300 text-3xs rounded-pill px-1.5 py-0.5">
                                            <i class="fas fa-robot me-0.5"></i>Bot
                                        </span>
                                    @endif
                                </div>
                                <div class="text-3xs text-muted font-monospace mt-0.5">
                                    Sesi: {{ substr($log->session_id, 0, 8) }}...
                                </div>
                            </td>

                            <!-- Halaman / URL -->
                            <td>
                                <div class="fw-semibold text-xs text-slate-800 text-truncate" style="max-width: 280px;" title="{{ $log->page_name }}">
                                    {{ $log->page_name }}
                                </div>
                                <a href="{{ $log->url }}" target="_blank" class="text-3xs text-muted text-decoration-none text-truncate d-block font-monospace" style="max-width: 280px;" title="{{ $log->url }}">
                                    <i class="fas fa-external-link-alt me-1 text-slate-400" style="font-size: 8px;"></i>{{ parse_url($log->url, PHP_URL_PATH) ?: '/' }}
                                </a>
                            </td>

                            <!-- Perangkat & OS -->
                            <td>
                                <div class="d-flex align-items-center gap-1.5 text-xs text-slate-700">
                                    <i class="{{ $log->device_icon }} text-emerald-600"></i>
                                    <span class="fw-semibold">{{ ucfirst($log->device) }}</span>
                                </div>
                                <div class="text-3xs text-muted mt-0.5">
                                    {{ $log->platform }}
                                </div>
                            </td>

                            <!-- Browser -->
                            <td>
                                <span class="badge bg-slate-100 text-slate-700 text-xs fw-semibold px-2 py-1 rounded-2">
                                    {{ $log->browser }}
                                </span>
                            </td>

                            <!-- Referrer -->
                            <td class="pe-4">
                                @if($log->referrer)
                                    <a href="{{ $log->referrer }}" target="_blank" rel="noopener noreferrer" class="badge bg-indigo-50 text-indigo-700 border border-indigo-100 text-xs text-decoration-none text-truncate d-inline-block" style="max-width: 150px;" title="{{ $log->referrer }}">
                                        <i class="fas fa-arrow-up-right-from-square me-1" style="font-size: 8px;"></i>{{ $log->referrer_host ?: 'Rujukan Luar' }}
                                    </a>
                                @else
                                    <span class="text-xs text-muted">
                                        <i class="fas fa-arrow-down-long me-1 text-slate-300"></i>Langsung
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="text-muted small">
                                    <i class="fas fa-magnifying-glass fs-3 mb-2 d-block text-slate-300"></i>
                                    Tidak ada catatan log pengunjung yang sesuai filter.
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($logs->hasPages())
            <div class="p-3 border-top border-slate-100 d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div class="text-xs text-muted">
                    Menampilkan <strong>{{ $logs->firstItem() }}</strong> - <strong>{{ $logs->lastItem() }}</strong> dari <strong>{{ $logs->total() }}</strong> rekaman
                </div>
                <div>
                    {{ $logs->links() }}
                </div>
            </div>
        @endif
    </div>

</div>

<!-- Modal: Bersihkan Log Pengunjung -->
<div class="modal fade" id="clearVisitorLogModal" tabindex="-1" aria-labelledby="clearVisitorLogModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow-lg overflow-hidden">
            <div class="modal-header bg-danger text-white border-0 px-4 py-3">
                <h5 class="modal-title fs-6 fw-bold d-flex align-items-center gap-2" id="clearVisitorLogModalLabel">
                    <i class="fas fa-trash-can"></i>
                    <span>Bersihkan Log Pengunjung</span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.visitor-logs.clear') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <p class="small text-muted mb-3">
                        Pilih kriteria data log pengunjung yang ingin dihapus untuk menghemat ruang penyimpanan database server:
                    </p>

                    <div class="d-flex flex-column gap-2.5">
                        <label class="form-check p-3 rounded-3 border border-slate-200 cursor-pointer hover:bg-slate-50 d-flex align-items-start gap-2.5">
                            <input class="form-check-input mt-1" type="radio" name="retention" value="30_days" checked>
                            <div>
                                <div class="fw-semibold text-slate-800 small">Hapus Log > 30 Hari yang Lalu</div>
                                <div class="text-muted text-xs">Membersihkan rekaman kunjungan lebih lama dari 30 hari. Direkomendasikan.</div>
                            </div>
                        </label>

                        <label class="form-check p-3 rounded-3 border border-slate-200 cursor-pointer hover:bg-slate-50 d-flex align-items-start gap-2.5">
                            <input class="form-check-input mt-1" type="radio" name="retention" value="60_days">
                            <div>
                                <div class="fw-semibold text-slate-800 small">Hapus Log > 60 Hari yang Lalu</div>
                                <div class="text-muted text-xs">Menjaga data dua bulan terakhir tetap tersimpan.</div>
                            </div>
                        </label>

                        <label class="form-check p-3 rounded-3 border border-slate-200 cursor-pointer hover:bg-slate-50 d-flex align-items-start gap-2.5">
                            <input class="form-check-input mt-1" type="radio" name="retention" value="90_days">
                            <div>
                                <div class="fw-semibold text-slate-800 small">Hapus Log > 90 Hari yang Lalu</div>
                                <div class="text-muted text-xs">Menjaga data tiga bulan terakhir tetap tersimpan.</div>
                            </div>
                        </label>

                        <label class="form-check p-3 rounded-3 border border-slate-200 cursor-pointer hover:bg-slate-50 d-flex align-items-start gap-2.5">
                            <input class="form-check-input mt-1" type="radio" name="retention" value="bots_only">
                            <div>
                                <div class="fw-semibold text-slate-800 small">Hapus Hanya Trafik Bot / Crawler</div>
                                <div class="text-muted text-xs">Hapus seluruh rekaman crawler mesin pencari tanpa menyentuh trafik manusia.</div>
                            </div>
                        </label>

                        @if(auth()->user()->isSuperAdmin())
                            <label class="form-check p-3 rounded-3 border border-danger/30 bg-danger/5 cursor-pointer d-flex align-items-start gap-2.5">
                                <input class="form-check-input mt-1" type="radio" name="retention" value="all">
                                <div>
                                    <div class="fw-bold text-danger small d-flex align-items-center gap-1.5">
                                        <i class="fas fa-triangle-exclamation"></i>
                                        <span>Hapus Semua Log Pengunjung (Reset Total)</span>
                                    </div>
                                    <div class="text-danger text-xs opacity-75">Hanya Super Admin. Seluruh riwayat kunjungan akan dikosongkan.</div>
                                </div>
                            </label>
                        @endif
                    </div>
                </div>
                <div class="modal-footer bg-slate-50 border-0 px-4 py-3">
                    <button type="button" class="btn btn-outline-secondary btn-sm rounded-3 px-3" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger btn-sm rounded-3 px-4 fw-semibold" onclick="return confirm('Apakah Anda yakin ingin menghapus log pengunjung yang dipilih?')">
                        <i class="fas fa-trash-can me-1"></i>Eksekusi Pembersihan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('visitorTrendChart');
    if (!ctx) return;

    const chartLabels = {!! json_encode($chartDates) !!};
    const chartUniqueData = {!! json_encode($chartUnique) !!};
    const chartHitsData = {!! json_encode($chartHits) !!};

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: chartLabels,
            datasets: [
                {
                    label: 'Pengunjung Unik',
                    data: chartUniqueData,
                    borderColor: '#10b981',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    borderWidth: 2.5,
                    fill: true,
                    tension: 0.35,
                    pointBackgroundColor: '#10b981',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6
                },
                {
                    label: 'Total Pageviews',
                    data: chartHitsData,
                    borderColor: '#06b6d4',
                    backgroundColor: 'rgba(6, 182, 212, 0.05)',
                    borderWidth: 2,
                    borderDash: [5, 5],
                    fill: false,
                    tension: 0.35,
                    pointBackgroundColor: '#06b6d4',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    pointRadius: 3,
                    pointHoverRadius: 5
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                mode: 'index',
                intersect: false,
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: '#0f172a',
                    titleColor: '#ffffff',
                    bodyColor: '#e2e8f0',
                    padding: 10,
                    boxPadding: 4,
                    usePointStyle: true,
                    cornerRadius: 8
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: {
                            size: 11
                        },
                        color: '#64748b'
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        color: '#f1f5f9'
                    },
                    ticks: {
                        precision: 0,
                        font: {
                            size: 11
                        },
                        color: '#64748b'
                    }
                }
            }
        }
    });
});
</script>
@endpush
