@extends('layouts.app')

@section('title', 'Manajemen Pengguna & Hak Akses')

@section('content')
<div class="container-fluid px-0">

    <!-- Header & Breadcrumb -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
        <div>
            <div class="d-flex align-items-center gap-2 text-muted small mb-1">
                <a href="{{ route('admin.dashboard') }}" class="text-decoration-none text-muted">Dashboard</a>
                <span>&bull;</span>
                <span class="text-emerald-700 fw-semibold">Sistem &amp; Pengguna</span>
            </div>
            <h1 class="h3 fw-bold text-slate-800 mb-0">Manajemen Akun &amp; Hak Akses</h1>
            <p class="text-muted small mb-0">Kelola akun administrator, tentukan peran hirarki, dan atur menu apa saja yang diizinkan untuk diakses.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.activity-logs.index') }}" class="btn btn-outline-secondary d-inline-flex align-items-center gap-2 rounded-3 px-3 py-2 shadow-sm">
                <i class="fas fa-clock-rotate-left"></i>
                <span class="small fw-semibold">Log Aktivitas</span>
            </a>
            <a href="{{ route('admin.users.create') }}" class="btn btn-emerald-gradient text-white d-inline-flex align-items-center gap-2 rounded-3 px-3.5 py-2 shadow-sm">
                <i class="fas fa-user-plus"></i>
                <span class="small fw-semibold">Tambah Akun Baru</span>
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

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm border-0 d-flex align-items-center gap-3 p-3 mb-4" role="alert">
            <i class="fas fa-circle-exclamation fs-4 text-danger"></i>
            <div class="small fw-semibold">{{ session('error') }}</div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Stat Cards -->
    <div class="row g-3 mb-4">
        <div class="col-12 col-sm-6 col-xl-4">
            <div class="card border-0 rounded-4 shadow-sm h-100 overflow-hidden" style="background: linear-gradient(135deg, #022c22 0%, #064e3b 100%);">
                <div class="card-body p-3.5 text-white">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="text-emerald-200 small fw-bold text-uppercase tracking-wider">Hirarki Tertinggi</span>
                        <div class="w-10 h-10 rounded-3 d-flex align-items-center justify-content-center bg-white/10 text-amber-300">
                            <i class="fas fa-crown fs-5"></i>
                        </div>
                    </div>
                    <div class="h2 fw-bolder mb-1 text-white">{{ $totalSuperAdmin }}</div>
                    <div class="small text-emerald-100 opacity-90">Super Admin (Akses Tanpa Batas)</div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-4">
            <div class="card border-0 rounded-4 shadow-sm h-100 overflow-hidden bg-white">
                <div class="card-body p-3.5">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="text-muted small fw-bold text-uppercase tracking-wider">Staf / Operator</span>
                        <div class="w-10 h-10 rounded-3 d-flex align-items-center justify-content-center bg-emerald-50 text-emerald-700">
                            <i class="fas fa-user-shield fs-5"></i>
                        </div>
                    </div>
                    <div class="h2 fw-bolder text-slate-800 mb-1">{{ $totalAdmin }}</div>
                    <div class="small text-muted">Admin Terbatas (Menu Terpilih)</div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-12 col-xl-4">
            <div class="card border-0 rounded-4 shadow-sm h-100 overflow-hidden bg-white">
                <div class="card-body p-3.5">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="text-muted small fw-bold text-uppercase tracking-wider">Total Akun Terdaftar</span>
                        <div class="w-10 h-10 rounded-3 d-flex align-items-center justify-content-center bg-blue-50 text-primary">
                            <i class="fas fa-users fs-5"></i>
                        </div>
                    </div>
                    <div class="h2 fw-bolder text-slate-800 mb-1">{{ $users->total() }}</div>
                    <div class="small text-muted">Akun Aktif di Sistem</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Card -->
    <div class="card border-0 rounded-4 shadow-sm overflow-hidden bg-white">
        
        <!-- Filter Toolbar -->
        <div class="card-header bg-white border-bottom p-3 p-md-3.5">
            <form method="GET" action="{{ route('admin.users.index') }}" class="row g-2 align-items-center">
                <div class="col-12 col-md-5 col-lg-6">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-slate-50 border-end-0 text-muted ps-3">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" name="search" class="form-control bg-slate-50 border-start-0 ps-1" placeholder="Cari nama atau email pengguna..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-6 col-md-3 col-lg-3">
                    <select name="role" class="form-select form-select-sm bg-slate-50 text-muted" onchange="this.form.submit()">
                        <option value="">Semua Peran (Role)</option>
                        <option value="super_admin" {{ request('role') == 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin Staf</option>
                    </select>
                </div>
                <div class="col-6 col-md-4 col-lg-3 d-flex gap-2">
                    <button type="submit" class="btn btn-sm btn-emerald-gradient text-white flex-grow-1">Filter</button>
                    @if(request()->hasAny(['search', 'role']))
                        <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-secondary" title="Reset Filter">
                            <i class="fas fa-rotate-left"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Table View -->
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-slate-50 text-muted text-uppercase" style="font-size: 0.72rem; letter-spacing: 0.6px;">
                    <tr>
                        <th class="ps-3.5 py-3">Pengguna</th>
                        <th class="py-3">Peran / Hirarki</th>
                        <th class="py-3" style="width: 45%;">Menu Yang Diizinkan</th>
                        <th class="py-3">Dibuat Pada</th>
                        <th class="text-end pe-3.5 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($users as $user)
                        <tr>
                            <!-- User Name & Avatar -->
                            <td class="ps-3.5 py-3">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="user-avatar-circle {{ $user->isSuperAdmin() ? 'bg-amber-gold' : 'bg-emerald-grad' }}">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="fw-bold text-slate-900 d-flex align-items-center gap-2">
                                            <span>{{ $user->name }}</span>
                                            @if($user->id === Auth::id())
                                                <span class="badge bg-secondary-subtle text-secondary rounded-pill px-2 py-0.5" style="font-size: 0.65rem;">Akun Anda</span>
                                            @endif
                                        </div>
                                        <div class="text-muted small">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>

                            <!-- Role Badge -->
                            <td class="py-3">
                                @if($user->isSuperAdmin())
                                    <span class="badge badge-super-admin d-inline-flex align-items-center gap-1.5 px-2.5 py-1.5 rounded-pill shadow-xs">
                                        <i class="fas fa-crown text-amber-500"></i>
                                        <span class="fw-bold">Super Admin</span>
                                    </span>
                                @else
                                    <span class="badge badge-admin-staff d-inline-flex align-items-center gap-1.5 px-2.5 py-1.5 rounded-pill">
                                        <i class="fas fa-shield text-emerald-600"></i>
                                        <span class="fw-bold">Admin Staf</span>
                                    </span>
                                @endif
                            </td>

                            <!-- Allowed Menus Badges -->
                            <td class="py-3">
                                @if($user->isSuperAdmin())
                                    <div class="d-inline-flex align-items-center gap-1.5 text-success fw-semibold small bg-success-subtle px-2.5 py-1 rounded-3">
                                        <i class="fas fa-circle-check"></i>
                                        <span>Akses Penuh Seluruh Menu &amp; Pengaturan</span>
                                    </div>
                                @else
                                    @php
                                        $perms = $user->permissions ?? [];
                                        if (!is_array($perms)) {
                                            $perms = json_decode($perms, true) ?? [];
                                        }
                                        $permCount = count($perms);
                                    @endphp

                                    @if($permCount === 0)
                                        <span class="text-danger small fst-italic">
                                            <i class="fas fa-triangle-exclamation me-1"></i>Belum ada menu yang diizinkan
                                        </span>
                                    @else
                                        <div class="d-flex flex-wrap gap-1 align-items-center">
                                            <span class="badge bg-emerald-950 text-emerald-300 rounded-pill px-2 py-1 small">
                                                {{ $permCount }} Menu Diizinkan
                                            </span>
                                            @foreach(array_slice($perms, 0, 4) as $pKey)
                                                @if(isset($availableMenus[$pKey]))
                                                    <span class="badge bg-slate-100 text-slate-700 border rounded-2 px-2 py-1 small fw-normal">
                                                        <i class="{{ $availableMenus[$pKey]['icon'] }} me-1 text-emerald-600"></i>
                                                        {{ $availableMenus[$pKey]['label'] }}
                                                    </span>
                                                @endif
                                            @endforeach
                                            @if($permCount > 4)
                                                <span class="text-muted small fw-semibold">+{{ $permCount - 4 }} menu lainnya</span>
                                            @endif
                                        </div>
                                    @endif
                                @endif
                            </td>

                            <!-- Created At -->
                            <td class="py-3 text-muted small">
                                <div>{{ $user->created_at ? $user->created_at->translatedFormat('d M Y') : '-' }}</div>
                                <div class="text-xs opacity-75">{{ $user->created_at ? $user->created_at->format('H:i') : '' }} WIB</div>
                            </td>

                            <!-- Actions -->
                            <td class="text-end pe-3.5 py-3">
                                <div class="d-inline-flex gap-1.5">
                                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-light border text-primary rounded-2 px-2.5 py-1.5" title="Edit Profil & Hak Akses">
                                        <i class="fas fa-sliders"></i>
                                        <span class="d-none d-lg-inline ms-1 small fw-semibold">Atur Akses</span>
                                    </a>

                                    @if($user->id !== Auth::id())
                                        <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun {{ $user->name }}? Tindakan ini tidak dapat dibatalkan.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-light border text-danger rounded-2 px-2 py-1.5" title="Hapus Akun">
                                                <i class="fas fa-trash-can"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="text-muted mb-2">
                                    <i class="fas fa-users-slash fs-1 text-slate-300"></i>
                                </div>
                                <div class="fw-semibold text-slate-700">Tidak ada data pengguna ditemukan</div>
                                <div class="text-muted small">Coba ubah kata kunci pencarian atau filter peran akun.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($users->hasPages())
            <div class="card-footer bg-white border-top p-3 d-flex justify-content-between align-items-center">
                <div class="text-muted small">
                    Menampilkan {{ $users->firstItem() }} - {{ $users->lastItem() }} dari {{ $users->total() }} akun
                </div>
                <div>
                    {{ $users->links() }}
                </div>
            </div>
        @endif

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
    .user-avatar-circle {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 0.95rem;
        color: #ffffff;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        flex-shrink: 0;
    }
    .bg-amber-gold {
        background: linear-gradient(135deg, #d97706 0%, #b45309 100%);
        border: 2px solid #fbbf24;
    }
    .bg-emerald-grad {
        background: linear-gradient(135deg, #10b981 0%, #047857 100%);
        border: 2px solid #6ee7b7;
    }
    .badge-super-admin {
        background: #fef3c7;
        color: #92400e;
        border: 1px solid #fcd34d;
        font-size: 0.76rem;
    }
    .badge-admin-staff {
        background: #ecfdf5;
        color: #065f46;
        border: 1px solid #a7f3d0;
        font-size: 0.76rem;
    }
</style>
@endsection
