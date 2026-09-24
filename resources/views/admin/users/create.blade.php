@extends('layouts.app')

@section('title', 'Tambah Pengguna Baru')

@section('content')
<div class="container-fluid px-0">

    <!-- Header & Breadcrumb -->
    <div class="mb-4">
        <div class="d-flex align-items-center gap-2 text-muted small mb-1">
            <a href="{{ route('admin.dashboard') }}" class="text-decoration-none text-muted">Dashboard</a>
            <span>&bull;</span>
            <a href="{{ route('admin.users.index') }}" class="text-decoration-none text-muted">Sistem &amp; Pengguna</a>
            <span>&bull;</span>
            <span class="text-emerald-700 fw-semibold">Tambah Akun</span>
        </div>
        <h1 class="h3 fw-bold text-slate-800 mb-0">Tambah Akun Pengguna Baru</h1>
        <p class="text-muted small mb-0">Buat kredensial akun baru, tentukan peran hirarki, dan pilih menu apa saja yang diizinkan untuk diakses.</p>
    </div>

    <!-- Error Validation Alert -->
    @if($errors->any())
        <div class="alert alert-danger rounded-3 shadow-sm border-0 p-3 mb-4">
            <div class="fw-bold d-flex align-items-center gap-2 mb-2">
                <i class="fas fa-circle-exclamation"></i>
                <span>Terdapat beberapa kesalahan input:</span>
            </div>
            <ul class="mb-0 small ps-3">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.users.store') }}" id="userForm">
        @csrf

        <div class="row g-4">
            
            <!-- Left Column: Kredensial & Role -->
            <div class="col-12 col-lg-5">
                <div class="card border-0 rounded-4 shadow-sm bg-white p-3 p-md-4 mb-4">
                    <h5 class="fw-bold text-slate-900 mb-3 d-flex align-items-center gap-2">
                        <i class="fas fa-id-card text-emerald-600"></i>
                        <span>Informasi Kredensial</span>
                    </h5>

                    <!-- Name -->
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-slate-700">Nama Lengkap <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted border-end-0"><i class="fas fa-user"></i></span>
                            <input type="text" name="name" class="form-control border-start-0" placeholder="Contoh: Budi Santoso, S.Kom" value="{{ old('name') }}" required>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-slate-700">Alamat Email <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted border-end-0"><i class="fas fa-envelope"></i></span>
                            <input type="email" name="email" class="form-control border-start-0" placeholder="email@amiktaruna.ac.id" value="{{ old('email') }}" required>
                        </div>
                        <div class="form-text small">Email ini digunakan untuk autentikasi login ke panel admin.</div>
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-slate-700">Password <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted border-end-0"><i class="fas fa-lock"></i></span>
                            <input type="password" name="password" class="form-control border-start-0" placeholder="Minimal 6 karakter" required>
                        </div>
                    </div>

                    <!-- Password Confirmation -->
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-slate-700">Konfirmasi Password <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted border-end-0"><i class="fas fa-shield-check"></i></span>
                            <input type="password" name="password_confirmation" class="form-control border-start-0" placeholder="Ketik ulang password" required>
                        </div>
                    </div>

                    <hr class="my-3 text-muted">

                    <!-- Role Selection -->
                    <label class="form-label small fw-bold text-slate-700 mb-2">Tingkat Hirarki / Peran (Role) <span class="text-danger">*</span></label>
                    <div class="d-flex flex-column gap-2 mb-3">
                        
                        <!-- Role: Admin Staf -->
                        <label class="role-option-card p-3 rounded-3 border d-flex align-items-start gap-3 cursor-pointer" id="roleCardAdmin">
                            <input type="radio" name="role" value="admin" class="mt-1" {{ old('role', 'admin') === 'admin' ? 'checked' : '' }} onchange="onRoleChange('admin')">
                            <div>
                                <div class="fw-bold text-slate-800 d-flex align-items-center gap-1.5">
                                    <i class="fas fa-user-shield text-emerald-600"></i>
                                    <span>Admin Staf (Terbatas)</span>
                                </div>
                                <div class="text-muted small">Hanya dapat melihat dan mengakses menu-menu yang Anda centang di samping.</div>
                            </div>
                        </label>

                        <!-- Role: Super Admin -->
                        <label class="role-option-card p-3 rounded-3 border d-flex align-items-start gap-3 cursor-pointer" id="roleCardSuper">
                            <input type="radio" name="role" value="super_admin" class="mt-1" {{ old('role') === 'super_admin' ? 'checked' : '' }} onchange="onRoleChange('super_admin')">
                            <div>
                                <div class="fw-bold text-slate-800 d-flex align-items-center gap-1.5">
                                    <i class="fas fa-crown text-amber-500"></i>
                                    <span>Super Admin (Hirarki Tertinggi)</span>
                                </div>
                                <div class="text-muted small">Akses tanpa batas ke seluruh menu, kelola akun pengguna, dan akses Log Aktivitas.</div>
                            </div>
                        </label>

                    </div>

                    <div class="d-flex gap-2 mt-2">
                        <button type="submit" class="btn btn-emerald-gradient text-white flex-grow-1 py-2 fw-semibold shadow-sm">
                            <i class="fas fa-save me-1"></i> Simpan Akun Baru
                        </button>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary py-2 px-3">
                            Batal
                        </a>
                    </div>

                </div>
            </div>

            <!-- Right Column: Menu Permissions Checklist -->
            <div class="col-12 col-lg-7">
                <div class="card border-0 rounded-4 shadow-sm bg-white p-3 p-md-4 mb-4" id="permissionsContainer">
                    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-2 mb-3 pb-3 border-bottom">
                        <div>
                            <h5 class="fw-bold text-slate-900 mb-0 d-flex align-items-center gap-2">
                                <i class="fas fa-list-check text-emerald-600"></i>
                                <span>Pilihan Hak Akses Menu</span>
                            </h5>
                            <div class="text-muted small">Pilih menu apa saja yang diizinkan untuk dibuka oleh akun ini di panel admin.</div>
                        </div>
                        <div class="d-flex gap-1.5" id="permissionButtonsGroup">
                            <button type="button" class="btn btn-xs btn-outline-success px-2 py-1 small rounded-2" onclick="toggleAllPermissions(true)">
                                <i class="fas fa-check-double me-1"></i>Pilih Semua
                            </button>
                            <button type="button" class="btn btn-xs btn-outline-secondary px-2 py-1 small rounded-2" onclick="toggleAllPermissions(false)">
                                <i class="fas fa-xmark me-1"></i>Kosongkan
                            </button>
                        </div>
                    </div>

                    <!-- Super Admin notice banner (hidden by default unless super_admin selected) -->
                    <div id="superAdminNotice" class="alert alert-warning border-warning-subtle rounded-3 p-3 mb-3 d-none">
                        <div class="d-flex gap-2.5">
                            <i class="fas fa-crown text-amber-600 fs-4 mt-0.5"></i>
                            <div>
                                <div class="fw-bold text-amber-900 small">Peran Super Admin Aktif</div>
                                <div class="text-amber-800 small">Akun dengan peran Super Admin secara otomatis memiliki hak akses tak terbatas ke seluruh menu sistem (termasuk Manajemen Pengguna dan Log Aktivitas).</div>
                            </div>
                        </div>
                    </div>

                    <!-- Grid of Menu Checkboxes -->
                    <div class="row g-2.5" id="menuCheckboxesGrid">
                        @foreach($availableMenus as $key => $menu)
                            <div class="col-12 col-sm-6">
                                <label class="menu-check-card p-3 rounded-3 border h-100 d-flex align-items-start gap-3 cursor-pointer">
                                    <input type="checkbox" name="permissions[]" value="{{ $key }}" class="menu-checkbox form-check-input mt-1 flex-shrink-0" {{ (is_array(old('permissions')) && in_array($key, old('permissions'))) || old('role') === 'super_admin' ? 'checked' : '' }}>
                                    <div class="min-w-0">
                                        <div class="fw-bold text-slate-900 small d-flex align-items-center gap-2 mb-0.5">
                                            <i class="{{ $menu['icon'] }} text-emerald-600"></i>
                                            <span class="text-truncate">{{ $menu['label'] }}</span>
                                        </div>
                                        <div class="text-muted text-xs line-clamp-2" style="font-size: 0.75rem; line-height: 1.3;">{{ $menu['desc'] }}</div>
                                    </div>
                                </label>
                            </div>
                        @endforeach
                    </div>

                    <div class="alert alert-light border rounded-3 p-3 mt-3 mb-0 small text-muted">
                        <i class="fas fa-shield-halved text-emerald-600 me-1"></i>
                        <strong>Catatan Keamanan:</strong> Menu khusus <em>"Kelola Pengguna"</em> dan <em>"Log Aktivitas"</em> hanya dapat diakses oleh peran <strong>Super Admin</strong> demi menjaga integritas sistem.
                    </div>

                </div>
            </div>

        </div>
    </form>

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
    .role-option-card {
        background-color: #f8fafc;
        transition: all 0.2s ease;
    }
    .role-option-card:hover {
        background-color: #f1f5f9;
        border-color: #cbd5e1;
    }
    .menu-check-card {
        background-color: #fcfdfd;
        transition: all 0.2s ease;
    }
    .menu-check-card:hover {
        background-color: #f0fdf4;
        border-color: #86efac;
    }
    .cursor-pointer {
        cursor: pointer;
    }
</style>

<script>
    function onRoleChange(role) {
        const superNotice = document.getElementById('superAdminNotice');
        const checkboxes = document.querySelectorAll('.menu-checkbox');
        const btnGroup = document.getElementById('permissionButtonsGroup');

        if (role === 'super_admin') {
            superNotice.classList.remove('d-none');
            btnGroup.classList.add('opacity-50', 'pointer-events-none');
            checkboxes.forEach(cb => {
                cb.checked = true;
                cb.disabled = true;
            });
        } else {
            superNotice.classList.add('d-none');
            btnGroup.classList.remove('opacity-50', 'pointer-events-none');
            checkboxes.forEach(cb => {
                cb.disabled = false;
            });
        }
    }

    function toggleAllPermissions(check) {
        document.querySelectorAll('.menu-checkbox').forEach(cb => {
            if (!cb.disabled) {
                cb.checked = check;
            }
        });
    }

    // Init state on page load
    document.addEventListener('DOMContentLoaded', function () {
        const checkedRole = document.querySelector('input[name="role"]:checked')?.value || 'admin';
        onRoleChange(checkedRole);

        // Before submit, ensure disabled checkboxes are enabled so values are sent if needed
        document.getElementById('userForm').addEventListener('submit', function () {
            document.querySelectorAll('.menu-checkbox').forEach(cb => {
                cb.disabled = false;
            });
        });
    });
</script>
@endsection
