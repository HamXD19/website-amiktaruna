@extends('layouts.app')

@section('title', 'Log Aktivitas Sistem (Khusus Super Admin)')

@section('content')
<div class="container-fluid px-0">

    <!-- Header & Breadcrumb -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
        <div>
            <div class="d-flex align-items-center gap-2 text-muted small mb-1">
                <a href="{{ route('admin.dashboard') }}" class="text-decoration-none text-muted">Dashboard</a>
                <span>&bull;</span>
                <span class="text-emerald-700 fw-semibold">Sistem &amp; Audit</span>
            </div>
            <h1 class="h3 fw-bold text-slate-800 mb-0 d-flex align-items-center gap-2">
                <span>Log Aktivitas Sistem</span>
                <span class="badge bg-amber-500/10 text-amber-700 border border-amber-500/30 fs-xs py-1 px-2 rounded-pill font-monospace">Eksklusif Super Admin</span>
            </h1>
            <p class="text-muted small mb-0">Catatan riwayat audit lengkap seluruh tindakan pengguna, mutasi data, dan autentikasi login/logout.</p>
        </div>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-outline-danger d-inline-flex align-items-center gap-2 rounded-3 px-3 py-2 shadow-sm" data-bs-toggle="modal" data-bs-target="#clearLogModal">
                <i class="fas fa-trash-can"></i>
                <span class="small fw-semibold">Bersihkan Log</span>
            </button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary d-inline-flex align-items-center gap-2 rounded-3 px-3 py-2 shadow-sm">
                <i class="fas fa-users-gear"></i>
                <span class="small fw-semibold">Kelola Pengguna</span>
            </a>
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

    <!-- Stat Cards -->
    <div class="row g-3 mb-4">
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 rounded-4 shadow-sm h-100 bg-white p-3.5">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small fw-bold text-uppercase tracking-wider">Total Rekaman Log</span>
                    <div class="w-9 h-9 rounded-3 d-flex align-items-center justify-content-center bg-slate-100 text-slate-700">
                        <i class="fas fa-database fs-6"></i>
                    </div>
                </div>
                <div class="h3 fw-bolder text-slate-800 mb-0">{{ number_format($stats['total']) }}</div>
                <div class="text-xs text-muted mt-1">Seluruh riwayat tersimpan</div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 rounded-4 shadow-sm h-100 bg-white p-3.5">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small fw-bold text-uppercase tracking-wider">Aktivitas Hari Ini</span>
                    <div class="w-9 h-9 rounded-3 d-flex align-items-center justify-content-center bg-emerald-50 text-emerald-600">
                        <i class="fas fa-calendar-day fs-6"></i>
                    </div>
                </div>
                <div class="h3 fw-bolder text-emerald-700 mb-0">{{ number_format($stats['today_count']) }}</div>
                <div class="text-xs text-muted mt-1">Aksi tercatat sejak 00:00 WIB</div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 rounded-4 shadow-sm h-100 bg-white p-3.5">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small fw-bold text-uppercase tracking-wider">Perubahan Data</span>
                    <div class="w-9 h-9 rounded-3 d-flex align-items-center justify-content-center bg-blue-50 text-primary">
                        <i class="fas fa-pen-to-square fs-6"></i>
                    </div>
                </div>
                <div class="h3 fw-bolder text-slate-800 mb-0">{{ number_format($stats['mutations_count']) }}</div>
                <div class="text-xs text-muted mt-1">Aksi Tambah / Edit / Hapus</div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 rounded-4 shadow-sm h-100 bg-white p-3.5">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small fw-bold text-uppercase tracking-wider">Insiden Keamanan</span>
                    <div class="w-9 h-9 rounded-3 d-flex align-items-center justify-content-center bg-rose-50 text-rose-600">
                        <i class="fas fa-shield-virus fs-6"></i>
                    </div>
                </div>
                <div class="h3 fw-bolder {{ $stats['security_count'] > 0 ? 'text-rose-600' : 'text-slate-800' }} mb-0">
                    {{ number_format($stats['security_count']) }}
                </div>
                <div class="text-xs text-muted mt-1">Akses ilegal / Ditolak</div>
            </div>
        </div>
    </div>

    <!-- Table & Filters Card -->
    <div class="card border-0 rounded-4 shadow-sm overflow-hidden bg-white">
        
        <!-- Filter Toolbar -->
        <div class="card-header bg-white border-bottom p-3 p-md-3.5">
            <form method="GET" action="{{ route('admin.activity-logs.index') }}" class="row g-2 align-items-center">
                
                <!-- Search input -->
                <div class="col-12 col-lg-3">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-slate-50 border-end-0 text-muted ps-3">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" name="search" class="form-control bg-slate-50 border-start-0 ps-1" placeholder="Cari aktivitas, user, IP..." value="{{ request('search') }}">
                    </div>
                </div>

                <!-- Action filter -->
                <div class="col-6 col-sm-4 col-lg-2">
                    <select name="action" class="form-select form-select-sm bg-slate-50 text-muted">
                        <option value="">Semua Aksi</option>
                        <option value="LOGIN" {{ request('action') == 'LOGIN' ? 'selected' : '' }}>LOGIN</option>
                        <option value="LOGOUT" {{ request('action') == 'LOGOUT' ? 'selected' : '' }}>LOGOUT</option>
                        <option value="CREATE" {{ request('action') == 'CREATE' ? 'selected' : '' }}>CREATE (Tambah)</option>
                        <option value="UPDATE" {{ request('action') == 'UPDATE' ? 'selected' : '' }}>UPDATE (Ubah)</option>
                        <option value="DELETE" {{ request('action') == 'DELETE' ? 'selected' : '' }}>DELETE (Hapus)</option>
                        <option value="SECURITY" {{ request('action') == 'SECURITY' ? 'selected' : '' }}>SECURITY (Akses Ditolak)</option>
                    </select>
                </div>

                <!-- Module filter -->
                <div class="col-6 col-sm-4 col-lg-2">
                    <select name="module" class="form-select form-select-sm bg-slate-50 text-muted">
                        <option value="">Semua Modul</option>
                        @foreach($modules as $mod)
                            <option value="{{ $mod }}" {{ request('module') == $mod ? 'selected' : '' }}>{{ $mod }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- User filter -->
                <div class="col-6 col-sm-4 col-lg-2">
                    <select name="user_id" class="form-select form-select-sm bg-slate-50 text-muted">
                        <option value="">Semua Pengguna</option>
                        @foreach($users as $u)
                            <option value="{{ $u->id }}" {{ request('user_id') == $u->id ? 'selected' : '' }}>{{ $u->name }} ({{ $u->role === 'super_admin' ? 'Super Admin' : 'Admin' }})</option>
                        @endforeach
                    </select>
                </div>

                <!-- Date Range filter -->
                <div class="col-6 col-sm-6 col-lg-2">
                    <select name="date_range" class="form-select form-select-sm bg-slate-50 text-muted">
                        <option value="">Semua Waktu</option>
                        <option value="today" {{ request('date_range') == 'today' ? 'selected' : '' }}>Hari Ini</option>
                        <option value="7_days" {{ request('date_range') == '7_days' ? 'selected' : '' }}>7 Hari Terakhir</option>
                        <option value="30_days" {{ request('date_range') == '30_days' ? 'selected' : '' }}>30 Hari Terakhir</option>
                    </select>
                </div>

                <!-- Action Button -->
                <div class="col-12 col-sm-6 col-lg-1 d-flex gap-1.5">
                    <button type="submit" class="btn btn-sm btn-emerald-gradient text-white flex-grow-1">Filter</button>
                    @if(request()->hasAny(['search', 'action', 'module', 'user_id', 'date_range']))
                        <a href="{{ route('admin.activity-logs.index') }}" class="btn btn-sm btn-outline-secondary" title="Reset Filter">
                            <i class="fas fa-rotate-left"></i>
                        </a>
                    @endif
                </div>

            </form>
        </div>

        <!-- Table View -->
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 font-sans">
                <thead class="bg-slate-50 text-muted text-uppercase" style="font-size: 0.72rem; letter-spacing: 0.6px;">
                    <tr>
                        <th class="ps-3.5 py-3" style="width: 140px;">Waktu</th>
                        <th class="py-3" style="width: 200px;">Pengguna</th>
                        <th class="py-3" style="width: 110px;">Aksi</th>
                        <th class="py-3" style="width: 140px;">Modul</th>
                        <th class="py-3">Deskripsi Aktivitas</th>
                        <th class="text-end pe-3.5 py-3" style="width: 130px;">Alamat IP</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700 font-normal">
                    @forelse($logs as $log)
                        <tr>
                            <!-- Timestamp -->
                            <td class="ps-3.5 py-3">
                                <div class="small fw-semibold text-slate-800">{{ $log->created_at->format('d M Y') }}</div>
                                <div class="text-xs text-muted font-monospace">{{ $log->created_at->format('H:i:s') }} WIB</div>
                            </td>

                            <!-- User info -->
                            <td class="py-3">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="user-avatar-mini {{ $log->user_role === 'super_admin' ? 'bg-amber-gold' : 'bg-emerald-grad' }}">
                                        {{ strtoupper(substr($log->user_name, 0, 1)) }}
                                    </div>
                                    <div class="min-w-0">
                                        <div class="fw-bold text-slate-900 small text-truncate" style="max-width: 150px;">{{ $log->user_name }}</div>
                                        <span class="badge {{ $log->user_role === 'super_admin' ? 'bg-amber-100 text-amber-800' : 'bg-emerald-100 text-emerald-800' }} rounded-pill" style="font-size: 0.62rem; padding: 1px 6px;">
                                            {{ $log->user_role === 'super_admin' ? 'Super Admin' : 'Admin' }}
                                        </span>
                                    </div>
                                </div>
                            </td>

                            <!-- Action Badge -->
                            <td class="py-3">
                                @switch($log->action)
                                    @case('CREATE')
                                        <span class="badge bg-emerald-500/10 text-emerald-700 border border-emerald-500/30 rounded-pill px-2.5 py-1 small fw-bold">
                                            <i class="fas fa-plus me-1"></i>CREATE
                                        </span>
                                        @break
                                    @case('UPDATE')
                                        <span class="badge bg-blue-500/10 text-blue-700 border border-blue-500/30 rounded-pill px-2.5 py-1 small fw-bold">
                                            <i class="fas fa-pencil me-1"></i>UPDATE
                                        </span>
                                        @break
                                    @case('DELETE')
                                        <span class="badge bg-rose-500/10 text-rose-700 border border-rose-500/30 rounded-pill px-2.5 py-1 small fw-bold">
                                            <i class="fas fa-trash me-1"></i>DELETE
                                        </span>
                                        @break
                                    @case('LOGIN')
                                        <span class="badge bg-violet-500/10 text-violet-700 border border-violet-500/30 rounded-pill px-2.5 py-1 small fw-bold">
                                            <i class="fas fa-right-to-bracket me-1"></i>LOGIN
                                        </span>
                                        @break
                                    @case('LOGOUT')
                                        <span class="badge bg-slate-500/10 text-slate-700 border border-slate-500/30 rounded-pill px-2.5 py-1 small fw-bold">
                                            <i class="fas fa-right-from-bracket me-1"></i>LOGOUT
                                        </span>
                                        @break
                                    @case('SECURITY')
                                        <span class="badge bg-amber-500/10 text-amber-800 border border-amber-500/40 rounded-pill px-2.5 py-1 small fw-bold">
                                            <i class="fas fa-shield-halved me-1"></i>SECURITY
                                        </span>
                                        @break
                                    @default
                                        <span class="badge bg-slate-100 text-slate-700 border rounded-pill px-2.5 py-1 small fw-bold">
                                            {{ $log->action }}
                                        </span>
                                @endswitch
                            </td>

                            <!-- Module -->
                            <td class="py-3">
                                <span class="badge bg-slate-100 text-slate-800 border rounded-2 px-2 py-1 small fw-semibold">
                                    {{ $log->module }}
                                </span>
                            </td>

                            <!-- Description -->
                            <td class="py-3">
                                <div class="text-slate-800 small">{{ $log->description }}</div>
                                @if($log->user_agent)
                                    <div class="text-xs text-muted text-truncate mt-0.5" style="max-width: 380px;" title="{{ $log->user_agent }}">
                                        <i class="fas fa-laptop me-1 opacity-50"></i>{{ $log->user_agent }}
                                    </div>
                                @endif
                            </td>

                            <!-- IP Address -->
                            <td class="text-end pe-3.5 py-3">
                                <span class="font-monospace small text-muted bg-slate-50 border px-2 py-1 rounded-2">
                                    {{ $log->ip_address }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="text-muted mb-2">
                                    <i class="fas fa-clock-rotate-left fs-1 text-slate-300"></i>
                                </div>
                                <div class="fw-semibold text-slate-700">Belum ada riwayat aktivitas tercatat</div>
                                <div class="text-muted small">Aktivitas pengguna dan perubahan data akan otomatis terekam di sini.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($logs->hasPages())
            <div class="card-footer bg-white border-top p-3 d-flex flex-column flex-sm-row justify-content-between align-items-center gap-2">
                <div class="text-muted small">
                    Menampilkan {{ $logs->firstItem() }} - {{ $logs->lastItem() }} dari {{ $logs->total() }} entri log
                </div>
                <div>
                    {{ $logs->links() }}
                </div>
            </div>
        @endif

    </div>

</div>

<!-- Modal Bersihkan Log -->
<div class="modal fade" id="clearLogModal" tabindex="-1" aria-labelledby="clearLogModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <form method="POST" action="{{ route('admin.activity-logs.clear') }}">
                @csrf
                <div class="modal-header border-bottom p-3.5">
                    <h5 class="modal-title fw-bold text-slate-900 d-flex align-items-center gap-2" id="clearLogModalLabel">
                        <i class="fas fa-triangle-exclamation text-danger"></i>
                        <span>Bersihkan Riwayat Log Aktivitas</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-3.5">
                    <p class="small text-muted mb-3">Pilih opsi pembersihan riwayat log. Tindakan ini permanen dan tidak dapat dibatalkan.</p>
                    
                    <div class="d-flex flex-column gap-2 mb-3">
                        <label class="p-3 border rounded-3 d-flex align-items-center gap-3 cursor-pointer">
                            <input type="radio" name="retention" value="30_days" checked>
                            <div>
                                <div class="fw-bold small text-slate-800">Hapus log yang lebih dari 30 hari yang lalu</div>
                                <div class="text-muted text-xs">Menyimpan riwayat 30 hari terakhir untuk audit terkini.</div>
                            </div>
                        </label>

                        <label class="p-3 border rounded-3 d-flex align-items-center gap-3 cursor-pointer">
                            <input type="radio" name="retention" value="60_days">
                            <div>
                                <div class="fw-bold small text-slate-800">Hapus log yang lebih dari 60 hari yang lalu</div>
                                <div class="text-muted text-xs">Menyimpan riwayat 60 hari terakhir.</div>
                            </div>
                        </label>

                        <label class="p-3 border rounded-3 d-flex align-items-center gap-3 cursor-pointer border-danger-subtle bg-danger-subtle/20">
                            <input type="radio" name="retention" value="all">
                            <div>
                                <div class="fw-bold small text-danger">Kosongkan Seluruh Riwayat Log</div>
                                <div class="text-danger-emphasis text-xs">Menghapus semua entri riwayat tanpa kecuali.</div>
                            </div>
                        </label>
                    </div>
                </div>
                <div class="modal-footer border-top p-3 d-flex justify-content-end gap-2">
                    <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger btn-sm px-3" onclick="return confirm('Apakah Anda yakin ingin menghapus data log sesuai opsi yang dipilih?')">
                        <i class="fas fa-trash-can me-1"></i>Eksekusi Pembersihan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .btn-emerald-gradient {
        background: linear-gradient(135deg, #059669 0%, #047857 100%);
        border: 1px solid #10b981;
    }
    .btn-emerald-gradient:hover {
        background: linear-gradient(135deg, #047857 0%, #065f46 100%);
        color: #ffffff;
    }
    .user-avatar-mini {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 0.75rem;
        color: #ffffff;
        flex-shrink: 0;
    }
    .bg-amber-gold {
        background: linear-gradient(135deg, #d97706 0%, #b45309 100%);
    }
    .bg-emerald-grad {
        background: linear-gradient(135deg, #10b981 0%, #047857 100%);
    }
    .cursor-pointer {
        cursor: pointer;
    }
</style>
@endsection
