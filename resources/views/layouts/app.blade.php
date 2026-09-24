@php
    use App\Models\Setting;
    if (!isset($setting)) {
        try {
            $setting = Setting::first();
        } catch (\Throwable $e) {
            $setting = null;
        }
    }
    $authUser = Auth::user();
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Admin Panel') | {{ $setting->nama_website ?? 'AMIK Taruna' }}</title>
    
    @if(!empty($setting->logo))
        <link rel="shortcut icon" href="{{ asset('uploads/' . $setting->logo) }}">
    @endif

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome 6.5.2 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        :root {
            --sidebar-bg: #022c22;        /* emerald-950 */
            --sidebar-border: #064e3b;    /* emerald-900 */
            --sidebar-hover: #064e3b;     /* emerald-900 */
            --sidebar-active: #065f46;    /* emerald-800 */
            --amber-accent: #f59e0b;      /* amber-500 */
            --amber-light: #fcd34d;       /* amber-300 */
            --emerald-accent: #10b981;    /* emerald-500 */
            --bg-workspace: #f8fafc;      /* slate-50 / 100 */
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            background-color: var(--bg-workspace);
            color: #1e293b;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        /* Layout Structure */
        .admin-layout-container {
            display: flex;
            min-height: 100vh;
            width: 100%;
        }

        /* Sidebar Styling (Kraksaan Wetan Style) */
        .admin-sidebar {
            width: 270px;
            background-color: var(--sidebar-bg);
            color: #ffffff;
            position: sticky;
            top: 0;
            height: 100vh;
            z-index: 1040;
            display: flex;
            flex-direction: column;
            border-right: 1px solid var(--sidebar-border);
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            flex-shrink: 0;
        }

        .admin-sidebar-header {
            padding: 1.25rem 1.25rem;
            border-bottom: 1px solid var(--sidebar-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: rgba(2, 44, 34, 0.95);
        }

        .admin-brand-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: linear-gradient(135deg, #059669, #047857);
            border: 1px solid #10b981;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-size: 1.1rem;
            box-shadow: 0 4px 10px rgba(5, 150, 105, 0.3);
            flex-shrink: 0;
        }

        .admin-brand-title {
            font-size: 0.92rem;
            font-weight: 800;
            color: #ffffff;
            line-height: 1.2;
            letter-spacing: -0.2px;
        }

        .admin-brand-sub {
            font-size: 0.72rem;
            color: var(--amber-accent);
            font-weight: 700;
            letter-spacing: 0.3px;
        }

        /* Sidebar Nav Links */
        .admin-sidebar-nav {
            flex: 1;
            padding: 1rem 0.85rem;
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: #064e3b transparent;
        }

        .admin-sidebar-nav::-webkit-scrollbar {
            width: 5px;
        }
        .admin-sidebar-nav::-webkit-scrollbar-thumb {
            background-color: #064e3b;
            border-radius: 10px;
        }

        .nav-category-header {
            font-size: 0.65rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: rgba(52, 211, 153, 0.65);
            padding: 0.75rem 0.75rem 0.35rem;
            margin-top: 0.35rem;
        }

        .admin-nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0.65rem 0.9rem;
            border-radius: 12px;
            font-size: 0.82rem;
            font-weight: 600;
            color: #d1fae5;
            text-decoration: none;
            transition: all 0.2s ease;
            margin-bottom: 3px;
        }

        .admin-nav-item i, .admin-nav-item svg {
            width: 18px;
            text-align: center;
            font-size: 0.95rem;
            color: #34d399;
            flex-shrink: 0;
            transition: transform 0.2s ease;
        }

        .admin-nav-item:hover {
            background-color: var(--sidebar-hover);
            color: #ffffff;
        }

        .admin-nav-item:hover i, .admin-nav-item:hover svg {
            transform: scale(1.15);
            color: #6ee7b7;
        }

        .admin-nav-item.active {
            background-color: var(--sidebar-active);
            color: var(--amber-light);
            font-weight: 700;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            border-left: 3px solid var(--amber-accent);
        }

        .admin-nav-item.active i, .admin-nav-item.active svg {
            color: var(--amber-accent);
        }

        /* User Profile & Actions Footer */
        .admin-sidebar-footer {
            padding: 1rem 1.15rem;
            border-top: 1px solid var(--sidebar-border);
            background-color: rgba(1, 32, 25, 0.95);
        }

        .admin-user-card {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 0.85rem;
        }

        .admin-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, #10b981, #047857);
            color: #ffffff;
            font-weight: 800;
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 2px 6px rgba(0,0,0,0.2);
        }

        .admin-user-name {
            font-weight: 700;
            font-size: 0.82rem;
            color: #ffffff;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            line-height: 1.2;
        }

        .admin-role-badge {
            display: inline-block;
            font-size: 0.65rem;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 6px;
            background: rgba(16, 185, 129, 0.2);
            color: #6ee7b7;
            border: 1px solid rgba(16, 185, 129, 0.3);
            margin-top: 3px;
        }

        .btn-sidebar-pub {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 7px 12px;
            border-radius: 10px;
            background-color: #064e3b;
            color: #a7f3d0;
            font-size: 0.76rem;
            font-weight: 600;
            text-decoration: none;
            border: 1px solid rgba(52, 211, 153, 0.25);
            transition: all 0.2s ease;
            margin-bottom: 6px;
        }

        .btn-sidebar-pub:hover {
            background-color: #047857;
            color: #ffffff;
        }

        .btn-sidebar-logout {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 7px 12px;
            border-radius: 10px;
            background-color: rgba(159, 18, 57, 0.45);
            color: #fecdd3;
            font-size: 0.76rem;
            font-weight: 600;
            border: 1px solid rgba(225, 29, 72, 0.35);
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .btn-sidebar-logout:hover {
            background-color: #9f1239;
            color: #ffffff;
        }

        /* Workspace & Topbar */
        .admin-main-workspace {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
            min-height: 100vh;
        }

        .admin-topbar {
            background: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            padding: 0.85rem 1.75rem;
            position: sticky;
            top: 0;
            z-index: 1030;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
        }

        .topbar-title {
            font-size: 0.98rem;
            font-weight: 800;
            color: #0f172a;
            margin: 0;
            line-height: 1.2;
        }

        .topbar-subtitle {
            font-size: 0.75rem;
            color: #64748b;
            margin: 0;
        }

        .status-pill-db {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 5px 12px;
            border-radius: 50px;
            background-color: #ecfdf5;
            color: #065f46;
            border: 1px solid #a7f3d0;
            font-size: 0.75rem;
            font-weight: 700;
        }

        .status-dot-pulse {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background-color: #10b981;
            box-shadow: 0 0 0 rgba(16, 185, 129, 0.4);
            animation: pulse-green 2s infinite;
        }

        @keyframes pulse-green {
            0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
            70% { transform: scale(1); box-shadow: 0 0 0 6px rgba(16, 185, 129, 0); }
            100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
        }

        .topbar-clock {
            font-size: 0.76rem;
            font-weight: 600;
            color: #475569;
            background: #f1f5f9;
            padding: 5px 12px;
            border-radius: 50px;
            border: 1px solid #e2e8f0;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        /* Page Content Area */
        .admin-page-content {
            flex: 1;
            padding: 1.75rem;
        }

        /* Mobile Backdrop */
        .admin-mobile-backdrop {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.6);
            z-index: 1035;
            backdrop-filter: blur(4px);
        }

        .admin-mobile-backdrop.show {
            display: block;
        }

        @media (max-width: 991.98px) {
            .admin-sidebar {
                position: fixed;
                left: 0;
                top: 0;
                transform: translateX(-100%);
            }
            .admin-sidebar.show {
                transform: translateX(0);
            }
            .admin-page-content {
                padding: 1.25rem 1rem;
            }
            .admin-topbar {
                padding: 0.75rem 1rem;
            }
        }
    </style>

    @stack('styles')
</head>
<body>

<div class="admin-layout-container">

    <!-- Mobile Backdrop -->
    <div id="sidebarBackdrop" class="admin-mobile-backdrop" onclick="toggleSidebar()"></div>

    <!-- 1. SIDEBAR (KRAKSAAN WETAN STYLE) -->
    <aside id="adminSidebar" class="admin-sidebar">
        
        <!-- Sidebar Brand Header -->
        <div class="admin-sidebar-header">
            <div class="d-flex align-items-center gap-2.5">
                @if(!empty($setting->logo))
                    <img src="{{ asset('uploads/' . $setting->logo) }}" alt="Logo" class="rounded-3" style="width: 38px; height: 38px; object-fit: contain; background: rgba(255,255,255,0.08); padding: 3px; border: 1px solid rgba(255,255,255,0.15);">
                @else
                    <div class="admin-brand-icon">
                        <i class="fas fa-shield-halved"></i>
                    </div>
                @endif
                <div>
                    <div class="admin-brand-title">Panel Admin</div>
                    <div class="admin-brand-sub">{{ $setting->singkatan ?? 'AMIK Taruna' }}</div>
                </div>
            </div>
            <button class="btn btn-link text-emerald-300 p-0 d-lg-none" onclick="toggleSidebar()" style="color: #6ee7b7; font-size: 1.2rem;">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <!-- Sidebar Navigation Items -->
        <nav class="admin-sidebar-nav">
            
            <!-- SECTION: UTAMA -->
            @if($authUser && $authUser->hasPermission('dashboard'))
                <div class="nav-category-header">Ringkasan</div>
                <a href="{{ route('admin.dashboard') }}" class="admin-nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-house-chimney"></i>
                    <span>Dashboard</span>
                </a>
            @endif

            <!-- SECTION: KONTEN & PUBLIKASI -->
            @php
                $canSeeKonten = $authUser && (
                    $authUser->hasPermission('berita') ||
                    $authUser->hasPermission('beritapmb') ||
                    $authUser->hasPermission('layanan') ||
                    $authUser->hasPermission('pmb') ||
                    $authUser->hasPermission('kategori')
                );
            @endphp
            @if($canSeeKonten)
                <div class="nav-category-header">Konten &amp; Publikasi</div>
                
                @if($authUser->hasPermission('berita'))
                    <a href="{{ route('berita.index') }}" class="admin-nav-item {{ request()->routeIs('berita.*') ? 'active' : '' }}">
                        <i class="fas fa-newspaper"></i>
                        <span>Kelola Berita</span>
                    </a>
                @endif

                @if($authUser->hasPermission('beritapmb'))
                    <a href="{{ route('beritapmb.index') }}" class="admin-nav-item {{ request()->routeIs('beritapmb.*') ? 'active' : '' }}">
                        <i class="fas fa-bullhorn"></i>
                        <span>Berita PMB</span>
                    </a>
                @endif

                @if($authUser->hasPermission('layanan'))
                    <a href="{{ route('admin.layanan') }}" class="admin-nav-item {{ request()->routeIs('admin.layanan*') ? 'active' : '' }}">
                        <i class="fas fa-hand-holding-heart"></i>
                        <span>Layanan Kampus</span>
                    </a>
                @endif

                @if($authUser->hasPermission('pmb'))
                    <a href="{{ route('pmb.index') }}" class="admin-nav-item {{ request()->routeIs('pmb.*') ? 'active' : '' }}">
                        <i class="fas fa-user-graduate"></i>
                        <span>PMB &amp; Formulir</span>
                    </a>
                @endif

                @if($authUser->hasPermission('kategori'))
                    <a href="{{ route('admin.kategori.index') }}" class="admin-nav-item {{ request()->routeIs('admin.kategori.*') ? 'active' : '' }}">
                        <i class="fas fa-tags"></i>
                        <span>Master Kategori</span>
                    </a>
                @endif
            @endif

            <!-- SECTION: AKADEMIK & LEMBAGA MUTU -->
            @php
                $canSeeAkademik = $authUser && (
                    $authUser->hasPermission('program_studi') ||
                    $authUser->hasPermission('akreditasi') ||
                    $authUser->hasPermission('dosen') ||
                    $authUser->hasPermission('profil_lulusan') ||
                    $authUser->hasPermission('ppm') ||
                    $authUser->hasPermission('lppm')
                );
            @endphp
            @if($canSeeAkademik)
                <div class="nav-category-header">Akademik &amp; Lembaga Mutu</div>

                @if($authUser->hasPermission('program_studi'))
                    <a href="{{ route('program-studi.index') }}" class="admin-nav-item {{ request()->routeIs('program-studi.*') ? 'active' : '' }}">
                        <i class="fas fa-graduation-cap"></i>
                        <span>Program Studi</span>
                    </a>
                @endif

                @if($authUser->hasPermission('akreditasi'))
                    <a href="{{ route('akreditasi.index') }}" class="admin-nav-item {{ request()->routeIs('akreditasi.*') ? 'active' : '' }}">
                        <i class="fas fa-award"></i>
                        <span>Kelola Akreditasi</span>
                    </a>
                @endif

                @if($authUser->hasPermission('dosen'))
                    <a href="{{ route('admin.dosen') }}" class="admin-nav-item {{ request()->routeIs('admin.dosen*') && !request()->routeIs('admin.profil.dosen*') ? 'active' : '' }}">
                        <i class="fas fa-chalkboard-user"></i>
                        <span>Data Dosen</span>
                    </a>

                    <a href="{{ route('admin.profil.dosen') }}" class="admin-nav-item {{ request()->routeIs('admin.profil.dosen*') ? 'active' : '' }}">
                        <i class="fas fa-id-badge"></i>
                        <span>Profil Dosen</span>
                    </a>
                @endif

                @if($authUser->hasPermission('profil_lulusan'))
                    <a href="{{ route('profil-lulusan.index') }}" class="admin-nav-item {{ request()->routeIs('profil-lulusan.*') ? 'active' : '' }}">
                        <i class="fas fa-user-check"></i>
                        <span>Profil Lulusan</span>
                    </a>
                @endif

                @if($authUser->hasPermission('ppm'))
                    <a href="{{ route('admin.ppm') }}" class="admin-nav-item {{ request()->routeIs('admin.ppm*') ? 'active' : '' }}">
                        <i class="fas fa-shield-halved"></i>
                        <span>Pusat Mutu (PPM)</span>
                    </a>
                @endif

                @if($authUser->hasPermission('lppm'))
                    <a href="{{ route('admin.lppm') }}" class="admin-nav-item {{ request()->routeIs('admin.lppm*') ? 'active' : '' }}">
                        <i class="fas fa-microscope"></i>
                        <span>Riset &amp; LPPM</span>
                    </a>
                @endif
            @endif

            <!-- SECTION: PROFIL & PENGATURAN -->
            @php
                $canSeeProfil = $authUser && (
                    $authUser->hasPermission('visimisi') ||
                    $authUser->hasPermission('alumni') ||
                    $authUser->hasPermission('kritiksaran') ||
                    $authUser->hasPermission('ppks') ||
                    $authUser->hasPermission('setting')
                );
            @endphp
            @if($canSeeProfil)
                <div class="nav-category-header">Profil &amp; Konfigurasi</div>

                @if($authUser->hasPermission('visimisi'))
                    <a href="{{ route('admin.visimisi') }}" class="admin-nav-item {{ request()->routeIs('admin.visimisi*') ? 'active' : '' }}">
                        <i class="fas fa-bullseye"></i>
                        <span>Visi &amp; Misi</span>
                    </a>
                @endif

                @if($authUser->hasPermission('alumni'))
                    <a href="{{ route('alumni_section.index') }}" class="admin-nav-item {{ request()->routeIs('alumni_section.*') ? 'active' : '' }}">
                        <i class="fas fa-user-tie"></i>
                        <span>Kelola Alumni</span>
                    </a>
                @endif

                @if($authUser->hasPermission('kritiksaran'))
                    <a href="{{ route('kritiksaran.index') }}" class="admin-nav-item {{ request()->routeIs('kritiksaran.*') ? 'active' : '' }}">
                        <i class="fas fa-envelope-open-text"></i>
                        <span>Kritik &amp; Saran</span>
                    </a>
                @endif

                @if($authUser->hasPermission('ppks'))
                    @php
                        $ppksNewCount = class_exists(\App\Models\PPKSLaporan::class) ? \App\Models\PPKSLaporan::where('status', 'baru')->count() : 0;
                    @endphp
                    <a href="{{ route('admin.ppks.index') }}" class="admin-nav-item {{ request()->routeIs('admin.ppks.*') ? 'active' : '' }} d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center gap-3">
                            <i class="fas fa-shield-alt text-danger"></i>
                            <span>Layanan PPKS</span>
                        </div>
                        @if($ppksNewCount > 0)
                            <span class="badge bg-danger rounded-pill px-2 py-0.5" style="font-size: 10px;">{{ $ppksNewCount }}</span>
                        @endif
                    </a>
                @endif

                @if($authUser->hasPermission('setting'))
                    <a href="{{ route('setting.edit') }}" class="admin-nav-item {{ request()->routeIs('setting.*') ? 'active' : '' }}">
                        <i class="fas fa-sliders"></i>
                        <span>Setting Website</span>
                    </a>
                @endif
            @endif

            <!-- SECTION: SUPER ADMIN EKSKLUSIF -->
            @if($authUser && $authUser->isSuperAdmin())
                <div class="nav-category-header text-amber-300 d-flex align-items-center gap-1.5" style="color: #fcd34d !important;">
                    <i class="fas fa-crown text-amber-400" style="font-size: 0.68rem;"></i>
                    <span>Sistem &amp; Hak Akses</span>
                </div>

                <a href="{{ route('admin.users.index') }}" class="admin-nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i class="fas fa-users-gear text-amber-400"></i>
                    <span>Kelola Pengguna</span>
                </a>

                <a href="{{ route('admin.activity-logs.index') }}" class="admin-nav-item {{ request()->routeIs('admin.activity-logs.*') ? 'active' : '' }}">
                    <i class="fas fa-clock-rotate-left text-amber-400"></i>
                    <span>Log Aktivitas</span>
                </a>
            @endif

        </nav>

        <!-- Sidebar User Footer -->
        <div class="admin-sidebar-footer">
            <div class="admin-user-card">
                <div class="admin-avatar" style="{{ $authUser && $authUser->isSuperAdmin() ? 'background: linear-gradient(135deg, #d97706, #b45309); border: 2px solid #fcd34d;' : '' }}">
                    {{ strtoupper(substr($authUser->name ?? 'A', 0, 1)) }}
                </div>
                <div class="min-w-0 flex-grow-1">
                    <div class="admin-user-name text-truncate">{{ $authUser->name ?? 'Administrator' }}</div>
                    @if($authUser && $authUser->isSuperAdmin())
                        <span class="admin-role-badge" style="background: rgba(245, 158, 11, 0.2); color: #fde68a; border-color: rgba(245, 158, 11, 0.4);">
                            <i class="fas fa-crown me-1 text-amber-400" style="font-size: 0.65rem;"></i>Super Admin
                        </span>
                    @else
                        <span class="admin-role-badge">
                            <i class="fas fa-user-shield me-1 text-emerald-400" style="font-size: 0.65rem;"></i>Admin Staf
                        </span>
                    @endif
                </div>
            </div>

            <a href="{{ url('/') }}" target="_blank" class="btn-sidebar-pub">
                <i class="fas fa-arrow-up-right-from-square"></i>
                <span>Buka Website Publik</span>
            </a>

            <form method="POST" action="{{ route('logout') }}" id="logoutForm">
                @csrf
                <button type="submit" class="btn-sidebar-logout">
                    <i class="fas fa-right-from-bracket"></i>
                    <span>Keluar (Logout)</span>
                </button>
            </form>
        </div>

    </aside>

    <!-- 2. MAIN WORKSPACE -->
    <div class="admin-main-workspace">
        
        <!-- Topbar Header -->
        <header class="admin-topbar">
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-outline-secondary btn-sm d-lg-none rounded-3 px-2 py-1.5" onclick="toggleSidebar()">
                    <i class="fas fa-bars"></i>
                </button>
                <div>
                    <h1 class="topbar-title">Sistem Manajemen Konten (CMS)</h1>
                    <p class="topbar-subtitle">AMIK Taruna Probolinggo &bull; Terhubung Database MySQL</p>
                </div>
            </div>

            <div class="d-flex align-items-center gap-2.5">
                <div class="topbar-clock d-none d-md-inline-flex" id="adminLiveClock">
                    <i class="far fa-clock text-success"></i>
                    <span id="liveClockText">--:--:--</span>
                </div>
                <span class="status-pill-db">
                    <span class="status-dot-pulse"></span>
                    <span>Database Aktif</span>
                </span>
            </div>
        </header>

        <!-- Flash Messages & Alerts -->
        @if(session('success'))
            <div class="px-4 pt-3">
                <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-xs d-flex align-items-center gap-2" role="alert">
                    <i class="fas fa-circle-check fa-lg text-success"></i>
                    <div>{{ session('success') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="px-4 pt-3">
                <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-xs d-flex align-items-center gap-2" role="alert">
                    <i class="fas fa-triangle-exclamation fa-lg text-danger"></i>
                    <div>{{ session('error') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif

        @if(isset($errors) && $errors->any())
            <div class="px-4 pt-3">
                <div class="alert alert-warning alert-dismissible fade show rounded-3 shadow-xs" role="alert">
                    <div class="fw-bold mb-1"><i class="fas fa-exclamation-circle me-1"></i>Terdapat kesalahan pada inputan:</div>
                    <ul class="mb-0 small ps-3">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif

        <!-- Main Content Area -->
        <main class="admin-page-content">
            @yield('content')
        </main>

    </div>

</div>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Toggle Mobile Sidebar
    function toggleSidebar() {
        const sidebar = document.getElementById('adminSidebar');
        const backdrop = document.getElementById('sidebarBackdrop');
        if (sidebar && backdrop) {
            sidebar.classList.toggle('show');
            backdrop.classList.toggle('show');
        }
    }

    // Live Clock in Topbar
    function updateClock() {
        const clockEl = document.getElementById('liveClockText');
        if (clockEl) {
            const now = new Date();
            const timeStr = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
            clockEl.textContent = timeStr + ' WIB';
        }
    }
    updateClock();
    setInterval(updateClock, 1000);

    // Initialize Lucide Icons if available
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
</script>

@stack('scripts')
</body>
</html>
