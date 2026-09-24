<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserManagementController extends Controller
{
    /**
     * Complete list of accessible menus in the admin panel
     */
    public static function availableMenus(): array
    {
        return [
            'dashboard' => [
                'label' => 'Dashboard Ringkasan',
                'icon' => 'fas fa-house-chimney',
                'desc' => 'Melihat ringkasan statistik dan overview sistem'
            ],
            'berita' => [
                'label' => 'Kelola Berita',
                'icon' => 'fas fa-newspaper',
                'desc' => 'Tambah, edit, dan publikasi berita/artikel kampus'
            ],
            'beritapmb' => [
                'label' => 'Berita PMB',
                'icon' => 'fas fa-bullhorn',
                'desc' => 'Pengumuman dan artikel khusus mahasiswa baru'
            ],
            'layanan' => [
                'label' => 'Layanan Kampus',
                'icon' => 'fas fa-hand-holding-heart',
                'desc' => 'Direktori layanan mahasiswa dan fasilitas'
            ],
            'pmb' => [
                'label' => 'PMB & Pendaftaran',
                'icon' => 'fas fa-user-graduate',
                'desc' => 'Gelombang pendaftaran, alur, jalur masuk, dan FAQ PMB'
            ],
            'kategori' => [
                'label' => 'Master Kategori',
                'icon' => 'fas fa-tags',
                'desc' => 'Kelola master kategori artikel dan berita'
            ],
            'program_studi' => [
                'label' => 'Program Studi & Kurikulum',
                'icon' => 'fas fa-graduation-cap',
                'desc' => 'Profil prodi, dokumen kurikulum, RPS, dan fasilitas'
            ],
            'akreditasi' => [
                'label' => 'Kelola Akreditasi',
                'icon' => 'fas fa-award',
                'desc' => 'Sertifikat akreditasi BAN-PT/LAM institusi dan prodi'
            ],
            'dosen' => [
                'label' => 'Data & Profil Dosen',
                'icon' => 'fas fa-chalkboard-user',
                'desc' => 'Data dosen pengajar, profil lengkap, dan kualifikasi'
            ],
            'profil_lulusan' => [
                'label' => 'Profil Lulusan',
                'icon' => 'fas fa-user-check',
                'desc' => 'Capaian kompetensi dan prospek karir lulusan'
            ],
            'ppm' => [
                'label' => 'Pusat Mutu (PPM)',
                'icon' => 'fas fa-shield-halved',
                'desc' => 'Dokumen mutu SPMI, kebijakan, dan hasil evaluasi'
            ],
            'lppm' => [
                'label' => 'Riset & LPPM',
                'icon' => 'fas fa-microscope',
                'desc' => 'Pengabdian masyarakat, penelitian dosen, dan jurnal'
            ],
            'visimisi' => [
                'label' => 'Visi & Misi',
                'icon' => 'fas fa-bullseye',
                'desc' => 'Visi, misi, tujuan, dan sasaran strategis institusi'
            ],
            'alumni' => [
                'label' => 'Kelola Alumni',
                'icon' => 'fas fa-user-tie',
                'desc' => 'Tracer study, data alumni, dan testimoni lulusan'
            ],
            'kritiksaran' => [
                'label' => 'Kritik & Saran',
                'icon' => 'fas fa-envelope-open-text',
                'desc' => 'Melihat dan menindaklanjuti pesan aspirasi publik'
            ],
            'ppks' => [
                'label' => 'Layanan PPKS',
                'icon' => 'fas fa-shield-alt',
                'desc' => 'Laporan kekerasan seksual & penanganan korban'
            ],
            'setting' => [
                'label' => 'Setting Website',
                'icon' => 'fas fa-sliders',
                'desc' => 'Identitas institusi, logo, kontak, maps, dan SEO'
            ],
        ];
    }

    /**
     * Display a listing of users.
     */
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->latest()->paginate(10)->withQueryString();
        $totalSuperAdmin = User::where('role', 'super_admin')->count();
        $totalAdmin = User::where('role', 'admin')->count();
        $availableMenus = self::availableMenus();

        return view('admin.users.index', compact('users', 'totalSuperAdmin', 'totalAdmin', 'availableMenus'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        $availableMenus = self::availableMenus();
        return view('admin.users.create', compact('availableMenus'));
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:super_admin,admin',
            'permissions' => 'nullable|array',
        ], [
            'name.required' => 'Nama pengguna wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.unique' => 'Email ini sudah digunakan oleh akun lain.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'role.required' => 'Pilih peran (role) akun.',
        ]);

        $permissions = $request->role === 'super_admin' ? array_keys(self::availableMenus()) : ($request->permissions ?? []);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'permissions' => $permissions,
        ]);

        ActivityLogger::log(
            'CREATE',
            'Manajemen Pengguna',
            "Membuat akun pengguna baru: {$user->name} ({$user->email}) sebagai " . ($user->role === 'super_admin' ? 'Super Admin' : 'Admin Staf')
        );

        return redirect()->route('admin.users.index')->with('success', 'Akun pengguna berhasil dibuat.');
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        $availableMenus = self::availableMenus();
        return view('admin.users.edit', compact('user', 'availableMenus'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:6|confirmed',
            'role' => 'required|in:super_admin,admin',
            'permissions' => 'nullable|array',
        ], [
            'name.required' => 'Nama pengguna wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.unique' => 'Email ini sudah digunakan oleh akun lain.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'role.required' => 'Pilih peran (role) akun.',
        ]);

        // Safety check: Prevent demoting yourself if you are the logged in Super Admin and only 1 super admin exists
        if ($user->id === Auth::id() && $request->role !== 'super_admin') {
            $otherSuperAdmins = User::where('role', 'super_admin')->where('id', '!=', $user->id)->count();
            if ($otherSuperAdmins === 0) {
                return back()->with('error', 'Gagal mengubah role! Harus ada setidaknya satu Super Admin yang aktif di sistem.');
            }
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        if ($request->role === 'super_admin') {
            $user->permissions = array_keys(self::availableMenus());
        } else {
            $user->permissions = $request->permissions ?? [];
        }

        $user->save();

        ActivityLogger::log(
            'UPDATE',
            'Manajemen Pengguna',
            "Memperbarui profil & hak akses akun: {$user->name} ({$user->email})"
        );

        return redirect()->route('admin.users.index')->with('success', 'Data pengguna dan hak akses berhasil diperbarui.');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        if ($user->id === Auth::id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri saat sedang login!');
        }

        if ($user->isSuperAdmin()) {
            $superAdminCount = User::where('role', 'super_admin')->count();
            if ($superAdminCount <= 1) {
                return back()->with('error', 'Super Admin terakhir tidak dapat dihapus!');
            }
        }

        $userName = $user->name;
        $userEmail = $user->email;
        $userRole = $user->role;

        $user->delete();

        ActivityLogger::log(
            'DELETE',
            'Manajemen Pengguna',
            "Menghapus akun: {$userName} ({$userEmail}) [Role: {$userRole}]"
        );

        return redirect()->route('admin.users.index')->with('success', "Akun {$userName} berhasil dihapus.");
    }
}
