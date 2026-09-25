# Website Profil & Sistem Informasi Kampus (CMS) AMIK Taruna Probolinggo

Sistem Informasi Profil Institusi Resmi dan Content Management System (CMS) **AMIK Taruna Probolinggo** berbasis Laravel 11, Tailwind CSS, Bootstrap 5, dan Vite. Dilengkapi arsitektur antarmuka **Emerald Dark Glassmorphism**, sistem hirarki **Super Admin**, manajemen hak akses menu dinamis (*Role-Based Access Control*), modul PMB dinamis, layanan pelaporan PPKS, serta pencatatan audit (*Activity Log*).

---

> ### 📌 PANDUAN RINGKAS DEPLOY HPANEL (KHUSUS DOSEN & TIM PENGUJI)
> 
> Website ini **100% siap hosting** di Hostinger Shared Hosting (hPanel). **Tidak perlu install Node.js / npm di server** karena seluruh file frontend sudah dikompilasi ke `public/build/`. File database lengkap juga sudah disediakan di dalam repo (`database/amik_database.sql`).
>
> **4 Langkah Cepat Deploy di hPanel:**
> 1. **Buat Database MySQL di hPanel**:
>    - Masuk ke **hPanel → Databases → Management**.
>    - Buat database baru (misal: `amik_db`) dan user baru (misal: `amik_user`). Catat nama database, user, dan password-nya.
>    - Klik tombol **Enter phpMyAdmin** pada database tersebut -> Masuk tab **Import** -> Upload file **`database/amik_database.sql`** yang ada di repository ini -> Klik **Go**.
> 2. **Hubungkan Repository via Git Deployment hPanel**:
>    - Masuk ke **hPanel → Git** (di menu Advanced).
>    - Repository: `https://github.com/HamXD19/website-amiktaruna.git`
>    - Branch: `main`
>    - Install directory: `public_html`
>    - Klik **Create / Deploy**. File otomatis masuk ke `public_html`.
> 3. **Konfigurasi File `.env`**:
>    - Buka **hPanel → File Manager** -> masuk ke folder `public_html/`.
>    - Klik file `.env.example` -> ubah nama (*Rename*) menjadi `.env` (atau buat file baru `.env`).
>    - Sesuaikan `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` dengan data database yang dibuat pada langkah 1.
>    - Pastikan `APP_KEY` terisi: `base64:LerE6P8PCElVrIb7q+QfwcqI+UwxXSdu4Tse/efiwOA=`
>    - Set `APP_URL` ke domain/subdomain Anda (misal `https://namadomain.com`).
> 4. **Pengaturan PHP**:
>    - Masuk ke **hPanel → PHP Configuration**, pastikan versi PHP adalah **PHP 8.2** atau **PHP 8.3**.
> 
> *Selesai! Website langsung aktif dan dapat diakses.*
> - **Login Admin**: Akses `/login` menggunakan email `humas.amiktarunaprobolinggo@gmail.com` atau `m.irhamauliaq@gmail.com`.

---

## 📋 Daftar Isi
1. [Panduan Ringkas Deploy hPanel (Khusus Dosen)](#-panduan-ringkas-deploy-hpanel-khusus-dosen--tim-penguji)
2. [Spesifikasi Server & Kebutuhan Sistem](#-spesifikasi-server--kebutuhan-sistem)
3. [Panduan Lengkap Deploy ke Hostinger (hPanel)](#-panduan-deploy-ke-hostinger-hpanel)
4. [Panduan Deploy Alternatif (cPanel & VPS)](#-panduan-deploy-alternatif-cpanel--vps)
5. [Arsitektur Akun & Hak Akses (Super Admin & Admin Staf)](#-arsitektur-akun--hak-akses)
6. [Daftar Fitur & Modul Utama](#-daftar-fitur--modul-utama)
7. [Troubleshooting Kendala Hosting di Hostinger](#-troubleshooting-kendala-hosting-di-hostinger)

---

## ⚙️ Spesifikasi Server & Kebutuhan Sistem

- **PHP Version**: `PHP >= 8.2` (Direkomendasikan **PHP 8.2** atau **PHP 8.3**)
- **Database**: MySQL `>= 8.0` atau MariaDB `>= 10.4`
- **Web Server**: Apache / LiteSpeed (dengan modul `mod_rewrite` aktif) atau Nginx
- **Ekstensi PHP Wajib**:
  - `pdo_mysql`, `fileinfo`, `gd`, `mbstring`, `curl`, `openssl`, `tokenizer`, `xml`, `bcmath`, `ctype`, `json`
- **Node.js**: **TIDAK DIBUTUHKAN DI SERVER**. Seluruh aset frontend (CSS, JS, Vue) **sudah dikompilasi siap pakai** di folder `public/build/`.
- **Gelar Resmi Lulusan**: Telah diseragamkan pada seluruh sistem menjadi **A.Md.** (Ahli Madya D3).

---

## 🚀 Panduan Deploy ke Hostinger (hPanel)

Berikut adalah panduan langkah demi langkah untuk mempublikasikan website ini ke hosting **Hostinger (hPanel)**:

### Langkah 1: Pengaturan PHP Version & Ekstensi di hPanel
1. Login ke akun Hostinger dan buka **hPanel**.
2. Masuk ke menu **Websites** -> klik **Manage** pada domain Anda.
3. Di bilah menu kiri, cari dan buka **PHP Configuration** (Konfigurasi PHP).
4. Pada tab **PHP Version**:
   - Pilih **PHP 8.2** atau **PHP 8.3**.
   - Klik **Update / Simpan**.
5. Pada tab **PHP Extensions**:
   - Pastikan ekstensi `pdo_mysql`, `fileinfo`, `gd`, `mbstring`, `curl`, `openssl`, `tokenizer`, dan `xml` dalam status tercentang (aktif).

---

### Langkah 2: Pengaturan Batas Upload Dokumen 30MB di hPanel
Aplikasi mendukung pengunggahan brosur PMB dan dokumen akademik (Kurikulum, RPS, SK Akreditasi) hingga ukuran **30 MB**.
1. Masih di menu **PHP Configuration**, klik tab **PHP Options**.
2. Sesuaikan parameter berikut:
   - `upload_max_filesize` = **32M** (atau 64M)
   - `post_max_size` = **36M** (atau 64M, harus lebih besar dari upload_max_filesize)
   - `memory_limit` = **256M** (atau 512M)
   - `max_execution_time` = **300**
3. Klik **Save / Simpan**.

---

### Langkah 3: Pembuatan Database MySQL di hPanel
1. Di hPanel, buka menu **Databases** -> **Management** (Manajemen Database).
2. Di bagian **Create a New MySQL Database and Database User**:
   - **Database Name**: Masukkan nama database (misal: `amik_profil` -> hasil: `u123456789_amik_profil`).
   - **Username**: Masukkan username (misal: `amik_user` -> hasil: `u123456789_amik_user`).
   - **Password**: Buat password yang kuat dan catat baik-baik.
3. Klik **Create / Buat**.
4. Catat ketiga data tersebut untuk dimasukkan ke file `.env`. Di Hostinger, `DB_HOST` adalah `localhost` atau `127.0.0.1`.

---

### Langkah 4: Upload File Proyek ke hPanel

Anda dapat memilih salah satu dari 2 metode upload berikut:

#### Opsi 4A: Menggunakan Fitur Git Deployment hPanel (Paling Disarankan)
1. Di menu hPanel, cari menu **Git** (di bawah menu *Advanced*).
2. Masukkan konfigurasi berikut:
   - **Repository**: `https://github.com/HamXD19/website-amiktaruna.git`
   - **Branch**: `main`
   - **Install directory**: `public_html` (atau kosongkan untuk root `public_html`).
3. Klik **Create / Buat**. Hostinger akan otomatis meng-clone seluruh file proyek.
4. Setiap ada pembaruan di GitHub ke depan, Anda cukup menekan tombol **Deploy** di halaman Git tersebut.

#### Opsi 4B: Menggunakan File Manager / ZIP Manual
1. Di komputer lokal, compress folder proyek menjadi file `.zip` (*kecuali folder `node_modules`*). Folder `vendor`, `public/build`, dan `public/uploads` wajib disertakan.
2. Buka **File Manager** di hPanel.
3. Masuk ke direktori `public_html/`.
4. Upload file `.zip` tersebut lalu klik kanan -> **Extract**.
5. Karena proyek ini sudah dilengkapi file `.htaccess` di root, seluruh request ke domain Anda akan otomatis diarahkan ke folder `public/` dengan aman tanpa perlu memindahkan file manual.

> **Tips Keamanan Struktur (Opsional)**:
> Jika ingin memisahkan core Laravel di luar `public_html`:
> 1. Ekstrak file zip ke folder sejajar `public_html` (misal: `/home/u123456/laravel_core`).
> 2. Pindahkan seluruh isi dari `laravel_core/public/` ke dalam `public_html/`.
> 3. Buka `public_html/index.php`, sesuaikan 2 baris path:
>    ```php
>    require __DIR__.'/../laravel_core/vendor/autoload.php';
>    $app = require_once __DIR__.'/../laravel_core/bootstrap/app.php';
>    ```

---

### Langkah 5: Konfigurasi File .env
1. Di **File Manager** hPanel, cari file `.env.example` lalu ubah namanya (**Rename**) menjadi `.env` (atau buat file baru bernama `.env`).
2. Buka dan edit file `.env`, lalu sesuaikan baris-baris berikut:

```env
APP_NAME="AMIK Taruna Probolinggo"
APP_ENV=production
APP_KEY=base64:LerE6P8PCElVrIb7q+QfwcqI+UwxXSdu4Tse/efiwOA=
APP_DEBUG=false
APP_URL=https://nama-domain-anda.ac.id

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=u123456789_nama_database_hpanel
DB_USERNAME=u123456789_nama_user_hpanel
DB_PASSWORD=password_database_anda

SESSION_DRIVER=file
CACHE_STORE=file
FILESYSTEM_DISK=public
```
3. Klik **Save & Close**.

---

### Langkah 6: Import Data / Migrasi Database

- **Cara 1 (Via phpMyAdmin hPanel - Paling Mudah)**:
  1. Di hPanel, buka menu **Databases** -> klik tombol **Enter phpMyAdmin** pada database yang baru dibuat.
  2. Buka tab **Import**.
  3. Upload file **`database/amik_database.sql`** yang sudah disediakan langsung di dalam repositori ini, lalu klik **Go / Kirim**. Data awal, tabel, dan akun admin akan otomatis terisi lengkap.

- **Cara 2 (Via SSH / Terminal hPanel)**:
  1. Buka menu **SSH Access** di hPanel, aktifkan dan buka terminal SSH.
  2. Masuk ke direktori proyek dan jalankan migrasi:
     ```bash
     cd ~/public_html
     php artisan migrate --force
     ```

---

### Langkah 7: Hak Akses Folder & Storage Link
1. **Hak Akses Folder (Permissions)**:
   Di File Manager hPanel, pastikan folder-folder berikut memiliki izin **775** atau **755**:
   - `storage/` beserta seluruh subfoldernya.
   - `bootstrap/cache/`
   - `public/uploads/`
2. **Storage Link**:
   - Jika memiliki akses SSH hPanel, jalankan:
     ```bash
     php artisan storage:link
     ```
   - Seluruh file gambar berita, logo, foto dosen terkompresi, dan brosur PMB telah tersimpan di direktori `public/uploads/` sehingga dapat langsung diakses publik secara aman.

---

## 🌐 Panduan Deploy Alternatif (cPanel & VPS)

### Shared Hosting / cPanel
1. Upload zip proyek ke direktori `laravel_core` di root home user (sejajar dengan `public_html`).
2. Pindahkan seluruh isi `laravel_core/public/` ke dalam `public_html/`.
3. Buka `public_html/index.php`, sesuaikan path:
   ```php
   require __DIR__.'/../laravel_core/vendor/autoload.php';
   $app = require_once __DIR__.'/../laravel_core/bootstrap/app.php';
   ```
4. Buat database di **MySQL Databases** cPanel dan sesuaikan file `.env`.
5. Import database melalui **phpMyAdmin** cPanel.

### VPS Linux (Ubuntu / Nginx)
```bash
cd /var/www/
git clone https://github.com/HamXD19/website-amiktaruna.git profil_amik
cd profil_amik
composer install --optimize-autoloader --no-dev
cp .env.example .env # Sesuaikan DB_* dan APP_KEY
php artisan migrate --force
php artisan storage:link
sudo chown -R www-data:www-data storage bootstrap/cache public/uploads
sudo chmod -R 775 storage bootstrap/cache public/uploads
php artisan optimize
```

---

## 🔐 Arsitektur Akun & Hak Akses

Sistem menggunakan pembagian peran (*Role-Based Access Control*):

### 1. Super Admin (Tingkat Tertinggi)
- Akses penuh ke seluruh modul sistem.
- **Menu Eksklusif**:
  - **Kelola Pengguna (`/admin/users`)**: Menambahkan akun baru, mengganti kata sandi, dan memilih menu apa saja yang diizinkan untuk setiap akun staf.
  - **Log Aktivitas (`/admin/activity-logs`)**: Memantau audit trail lengkap (login, logout, waktu, aksi CREATE/UPDATE/DELETE, modul, IP address, dan browser user-agent).

> **Akun Bawaan (Default):**
> - **Email**: `humas.amiktarunaprobolinggo@gmail.com` atau `m.irhamauliaq@gmail.com`
> - **Halaman Login**: `/login` (Pendaftaran publik `/register` dinonaktifkan demi keamanan).

### 2. Admin Staf (Dinamis Berdasarkan Izin)
- Dibuat dan dikonfigurasi langsung oleh Super Admin.
- Menu pada sidebar yang tidak diizinkan akan disembunyikan secara otomatis.
- Akses URL langsung ke menu tanpa izin otomatis diblokir (`403 Forbidden`) dan dicatat pada Activity Log.

---

## 🌟 Daftar Fitur & Modul Utama

1. **PMB (Penerimaan Mahasiswa Baru) - 100% Full Dinamis**:
   - Status live gelombang pendaftaran (buka/tutup, tanggal, kuota beasiswa).
   - Pengaturan Jalur Masuk (Reguler, Prestasi, KIP-K, Pindahan).
   - 4 Tahapan alur pendaftaran dan checklist berkas persyaratan.
   - Accordion FAQ interaktif & upload brosur PMB (hingga 30MB).
   - Tombol live WhatsApp Helpdesk panitia PMB.
2. **Akademik & Program Studi**:
   - Profil Program Studi dengan gelar resmi **A.Md.**
   - Profil Lulusan, Fasilitas Prodi, dan Dokumen Pedoman/Kurikulum/RPS.
   - Sertifikat dan data Akreditasi Institusi & Prodi.
3. **Layanan Satgas PPKS (Pencegahan & Penanganan Kekerasan Seksual)**:
   - Formulir pengaduan online anonim & aman dengan nomor tiket otomatis (`PPKS-YYYYMM-XXXX`).
   - Panel monitoring kasus dan catatan investigasi petugas.
4. **Lembaga & Dokumen Mutu**:
   - Pusat Penjaminan Mutu (PPM / SPMI) & Dokumen Mutu.
   - Lembaga Penelitian & Pengabdian Masyarakat (LPPM) & Portal Jurnal Riset.
5. **Publikasi & Optimasi Media**:
   - Portal Berita Kampus & Berita PMB dengan Master Kategori Universal.
   - Direktori Dosen & Profil Tenaga Pengajar (dilengkapi auto-kompresi gambar cerdas WebP/JPEG, menghemat beban server hingga 95%).
   - Tracer Study Alumni & Buku Kritik Saran Publik.

---

## 🛠️ Troubleshooting Kendala Hosting di Hostinger

| Kendala | Penyebab | Solusi |
|---|---|---|
| **500 Server Error** | `APP_KEY` kosong atau permission `storage/` terkunci | Buka `.env`, pastikan `APP_KEY` sudah terisi string base64. Pastikan folder `storage/` dan `bootstrap/cache/` berstatus writable (`chmod 775` atau `755`). |
| **Error Database Connection (2002)** | Kredensial database di `.env` salah | Di Hostinger, `DB_HOST` harus diisi `localhost` atau `127.0.0.1`. Pastikan nama database dan username menyertakan prefix akun Hostinger Anda (misal `u123456_amik`). |
| **Halaman sub-menu 404 Not Found** | Modul Apache Rewrite belum berjalan | Pastikan file `.htaccess` di root dan di dalam folder `public/` sudah ter-upload dengan benar. |
| **Gambar Berita / Dosen Tidak Muncul** | Folder upload belum berada di webroot | Pastikan folder `public/uploads` ada dan memiliki hak akses baca `755`. Pastikan `APP_URL` di `.env` sesuai dengan domain utama hosting Anda. |
| **Gagal Upload Berkas Brosur / Dokumen** | Batas ukuran upload PHP di hosting terlalu kecil | Naikkan `upload_max_filesize = 32M` dan `post_max_size = 36M` pada menu **PHP Configuration** -> tab **PHP Options** di hPanel. |
| **Akses Ditolak (403 Forbidden) di Panel Admin** | Akun staf belum diberi izin menu terkait | Login sebagai Super Admin, buka menu **Kelola Pengguna (`/admin/users`)**, lalu centang checklist izin menu untuk akun staf tersebut. |

---

**Hak Cipta © 2026 AMIK Taruna Probolinggo**  
*Dikembangkan untuk kemajuan digitalisasi informasi akademik dan pelayanan kampus.*
