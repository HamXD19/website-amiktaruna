# Website Profil & Sistem Manajemen Konten (CMS) AMIK Taruna Probolinggo

Aplikasi Web Resmi Profil Institusi dan Sistem Informasi Kampus **AMIK Taruna Probolinggo** berbasis Laravel 11, Tailwind CSS, dan Bootstrap 5 dengan arsitektur **Emerald Dark Glassmorphism**, sistem hirarki akun **Super Admin**, manajemen hak akses menu dinamis (Role-Based Access Control), dan sistem pencatatan riwayat audit (**Activity Log**).

---

## 📋 Daftar Isi
1. [Spesifikasi Server & Kebutuhan Sistem](#-spesifikasi-server--kebutuhan-sistem)
2. [Arsitektur Akun & Keamanan](#-arsitektur-akun--keamanan)
3. [Panduan Deploy / Hosting Cepat](#-panduan-deploy--hosting-cepat)
   - [Opsi 1: Shared Hosting / cPanel](#opsi-1-shared-hosting--cpanel-rekomendasi-hosting-kampus)
   - [Opsi 2: VPS (Ubuntu / Debian / Nginx / Apache)](#opsi-2-vps-linux-ubuntu--debian)
4. [Pengaturan PHP & Batas Upload Dokumen](#-pengaturan-php--batas-upload-dokumen)
5. [Daftar Fitur Sistem](#-daftar-fitur-sistem)
6. [Troubleshooting & Solusi Kendala Hosting](#-troubleshooting--solusi-kendala-hosting)

---

## ⚙️ Spesifikasi Server & Kebutuhan Sistem

Sebelum melakukan hosting, pastikan server memenuhi spesifikasi berikut:

- **PHP Version**: `PHP >= 8.2` (Direkomendasikan PHP 8.2 atau 8.3)
- **Database**: MySQL `>= 8.0` atau MariaDB `>= 10.4`
- **Web Server**: Apache (dengan modul `mod_rewrite` aktif) atau Nginx
- **Ekstensi PHP Wajib**:
  - `BCMath`
  - `Ctype`
  - `cURL`
  - `DOM`
  - `Fileinfo` (Wajib untuk validasi dokumen & gambar)
  - `JSON`
  - `Mbstring`
  - `OpenSSL`
  - `PCRE`
  - `PDO` & `pdo_mysql`
  - `Tokenizer`
  - `XML`
- **Composer**: Composer 2.x
- **Node.js**: *(Opsional saat hosting)* Karena seluruh aset frontend (CSS, JS, Vue, Vite) **sudah dikompilasi secara siap pakai** di direktori `public/build/`.

---

## 🔐 Arsitektur Akun & Keamanan

Sistem memiliki 2 tingkatan peran (role) akun:

### 1. Super Admin (Hirarki Tertinggi)
- Memiliki otoritas penuh tanpa batas (*unrestricted access*) ke seluruh fitur, modul, dan konfigurasi.
- **Eksklusif Super Admin**:
  - **Kelola Pengguna (`/admin/users`)**: Membuat akun baru, mengedit profil, mengatur password, dan menentukan checklist menu apa saja yang boleh diakses oleh tiap akun staf.
  - **Log Aktivitas (`/admin/activity-logs`)**: Memantau audit trail lengkap (riwayat login/logout, waktu, jenis aksi CREATE/UPDATE/DELETE, modul, alamat IP, dan user-agent).
- Dilengkapi proteksi keamanan: Super Admin tidak dapat menghapus akunnya sendiri yang sedang login dan tidak dapat menghapus Super Admin terakhir di sistem.

### 2. Admin Staf (Terbatas Dinamis)
- Akun operator/staf yang dibuat oleh Super Admin.
- Sidebar navigasi secara otomatis menyembunyikan menu-menu yang tidak diizinkan.
- Akses URL langsung ke menu terlarang otomatis dicegat oleh middleware keamanan (`403 Forbidden`) dan dicatat sebagai insiden keamanan pada Activity Log.

> **Informasi Akun Bawaan (Default):**
> - **Email Super Admin**: `m.irhamauliaq@gmail.com` atau `humas.amiktarunaprobolinggo@gmail.com`
> - **Halaman Login**: Akses melalui `/login` (Registrasi mandiri `/register` sengaja dialihkan ke login demi keamanan institusi).

---

## 🚀 Panduan Deploy / Hosting Cepat

### Opsi 1: Shared Hosting / cPanel (Rekomendasi Hosting Kampus)

Struktur aman untuk Laravel di cPanel adalah memisahkan folder core aplikasi dari folder `public_html`.

#### Langkah 1: Persiapan File
1. Zip seluruh file proyek ini, **kecuali** folder `node_modules` dan file `.env` lokal. Pastikan folder `public/build`, `public/uploads`, dan `vendor` sudah ikut ter-archive.

#### Langkah 2: Upload ke cPanel
1. Buka **cPanel File Manager**.
2. Buat folder baru di direktori root user (sejajar dengan `public_html`), misalnya folder `laravel_core`.
3. Upload dan ekstrak file zip ke dalam folder `laravel_core/`.
4. Pindahkan seluruh isi dari `laravel_core/public/` ke dalam folder `public_html/`.

#### Langkah 3: Sesuaikan Path `index.php` di `public_html`
Buka file `public_html/index.php` menggunakan code editor cPanel, ubah baris require menjadi:
```php
// Sesuaikan nama folder jika menggunakan nama selain laravel_core
require __DIR__.'/../laravel_core/vendor/autoload.php';

$app = require_once __DIR__.'/../laravel_core/bootstrap/app.php';
```

#### Langkah 4: Konfigurasi Database & File `.env`
1. Di cPanel, buat Database MySQL baru (misal: `amik_profil`) dan buat Pengguna MySQL beserta password-nya.
2. Berikan hak akses penuh (*ALL PRIVILEGES*) pengguna ke database tersebut.
3. Buka file `.env` di dalam `laravel_core/` (jika belum ada, salin dari `.env.example`).
4. Isi parameter berikut:
   ```env
   APP_NAME="AMIK Taruna Probolinggo"
   APP_ENV=production
   APP_KEY=base64:PASTE_APP_KEY_ANDA_DISINI
   APP_DEBUG=false
   APP_URL=https://nama-domain-kampus.ac.id

   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=nama_cpanel_database
   DB_USERNAME=nama_cpanel_user
   DB_PASSWORD=password_database_anda

   FILESYSTEM_DISK=public
   SESSION_DRIVER=file
   CACHE_STORE=file
   ```

#### Langkah 5: Import Database / Menjalankan Migrasi
- **Jika memiliki akses SSH / Terminal di cPanel**:
  ```bash
  cd ~/laravel_core
  php artisan migrate --force
  ```
- **Jika tanpa akses Terminal**:
  Export database lokal `amikprofil2` via phpMyAdmin lokal (.sql), lalu buka **phpMyAdmin** di cPanel dan lakukan **Import** file `.sql` ke database yang telah dibuat.

#### Langkah 6: Storage Link & Hak Akses Folder (Permissions)
1. Berikan hak akses tulis (*Writable*):
   - Folder `storage/` -> `chmod 775` (atau `755`)
   - Folder `bootstrap/cache/` -> `chmod 775`
   - Folder `public_html/uploads/` -> `chmod 775`
2. **Storage Link**:
   - Jika ada Terminal cPanel: jalankan `php artisan storage:link`.
   - Atau pastikan folder `uploads` berada di `public_html/uploads` agar gambar berita, logo, brosur PMB, dan dokumen prodi dapat diakses langsung oleh browser.

---

### Opsi 2: VPS Linux (Ubuntu / Debian)

#### 1. Masuk ke Server & Clone / Upload
```bash
cd /var/www/
git clone <url-repo> profil_amik
cd profil_amik
```

#### 2. Install Dependency & Setup Environtment
```bash
composer install --optimize-autoloader --no-dev
cp .env.example .env
nano .env # Sesuaikan DB, APP_URL, dan APP_KEY
php artisan key:generate
php artisan migrate --force
php artisan storage:link
```

#### 3. Permission Direktori
```bash
sudo chown -R www-data:www-data /var/www/profil_amik/storage /var/www/profil_amik/bootstrap/cache /var/www/profil_amik/public/uploads
sudo chmod -R 775 /var/www/profil_amik/storage /var/www/profil_amik/bootstrap/cache /var/www/profil_amik/public/uploads
```

#### 4. Konfigurasi Nginx VirtualHost
```nginx
server {
    listen 80;
    server_name amiktaruna.ac.id www.amiktaruna.ac.id;
    root /var/www/profil_amik/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    client_max_body_size 35M;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

#### 5. Optimasi Cache Produksi
```bash
php artisan optimize
```

---

## 📁 Pengaturan PHP & Batas Upload Dokumen

Aplikasi mendukung pengunggahan brosur PMB dan dokumen akademik (Kurikulum, RPS, SK Akreditasi) berupa `.pdf, .doc, .docx` hingga ukuran **30 MB**.

Pastikan konfigurasi `php.ini` pada hosting disesuaikan:
```ini
upload_max_filesize = 32M
post_max_size = 36M
memory_limit = 256M
max_execution_time = 300
```
*(Di cPanel, pengaturan ini dapat diubah melalui menu **Select PHP Version** -> **Options**).*

---

## 🌟 Daftar Fitur Sistem

1. **Penerimaan Mahasiswa Baru (PMB) - 100% Full Dinamis**:
   - Status live gelombang pendaftaran (buka/tutup, tanggal, kuota beasiswa).
   - Pengaturan Jalur Masuk (Reguler, Prestasi, KIP-K, Pindahan).
   - Tahapan alur 4 langkah pendaftaran mahasiswa baru.
   - Checklist berkas persyaratan calon mahasiswa baru.
   - Dynamic FAQ PMB (Accordion interaktif).
   - Upload & download berkas brosur PMB (maksimal 30MB).
   - Integrasi tombol WhatsApp Helpdesk PMB langsung ke nomor admin.
2. **Akademik & Program Studi**:
   - Manajemen Program Studi dengan gelar resmi lulusan: **A.Md.** (Ahli Madya D3).
   - Profil Lulusan, Fasilitas Prodi, dan Dokumen Pedoman/Kurikulum/RPS.
   - Sertifikat dan data Akreditasi Institusi & Prodi.
3. **Layanan PPKS (Pencegahan & Penanganan Kekerasan Seksual)**:
   - Form pelaporan online anonim & rahasia bagi korban/saksi kekerasan seksual.
   - Sistem auto-generate **Kode Tiket Pelaporan** (misal: `PPKS-202609-XXXX`).
   - Manajemen pelaporan di panel admin dengan status investigasi & catatan penanganan petugas.
4. **Lembaga Mutu Kampus**:
   - Pusat Penjaminan Mutu (PPM / SPMI) & Dokumen Mutu.
   - Lembaga Penelitian & Pengabdian Masyarakat (LPPM) & Portal Jurnal Riset.
5. **Konten & Publikasi**:
   - Portal Berita Kampus & Berita PMB dengan Master Kategori Universal.
   - Direktori Layanan Mahasiswa & Fasilitas Kampus.
   - Direktori Dosen & Profil Tenaga Pengajar.
   - Tracer Study Alumni & Buku Kritik Saran Publik.
6. **Sistem Keamanan & Log Aktivitas (Audit Trail)**:
   - Manajemen Pengguna oleh Super Admin.
   - Pembagian hak akses per menu secara granular.
   - Pencatatan otomatis waktu, aksi, modul, nama user, alamat IP, dan perangkat.

---

## 🛠️ Troubleshooting & Solusi Kendala Hosting

1. **Error `500 Server Error` saat pertama kali dibuka**:
   - Jalankan `php artisan key:generate` jika `APP_KEY` di `.env` masih kosong.
   - Periksa izin folder `storage/` dan `bootstrap/cache/` (harus `775` atau writable).
   - Buka file `storage/logs/laravel.log` untuk melihat pesan error spesifik.
2. **Error `403 Forbidden` saat mengakses menu admin tertentu**:
   - Akun Anda memiliki peran *Admin Staf* dan belum diberikan izin oleh Super Admin untuk menu tersebut. Hubungi Super Admin untuk mencentang hak akses menu Anda di `/admin/users`.
3. **Gambar / File upload tidak tampil (404 Not Found)**:
   - Pastikan folder `public/uploads` telah di-upload ke server dan memiliki hak akses baca/tulis (`755` atau `775`).
   - Pastikan path `APP_URL` di `.env` sudah sesuai dengan domain atau subdomain hosting Anda (misal `https://amiktaruna.ac.id`).
4. **Perubahan data tidak muncul / Cache usang**:
   - Jalankan perintah berikut di terminal:
     ```bash
     php artisan optimize:clear
     ```
   - Atau hapus file cache manual di folder `bootstrap/cache/` (kecuali `.gitignore`).

---

**Dikembangkan untuk**: AMIK Taruna Probolinggo  
**Lisensi**: Hak Cipta Dilindungi & Terlisensi untuk AMIK Taruna Probolinggo.
