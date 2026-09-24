# 📌 PANDUAN DEPLOY & HOSTING KHUSUS DOSEN / ADMIN SERVER
### Sistem Informasi Profil Institusi & CMS AMIK Taruna Probolinggo

Dokumen ini disusun khusus sebagai petunjuk praktis bagi Dosen Pengampu / Administrator Server untuk mempublikasikan (hosting) aplikasi ini ke server produksi (**cPanel / Shared Hosting / VPS**).

---

## ⚡ Ringkasan Cepat untuk Admin Server
- **Framework**: Laravel 11 (PHP 8.2+)
- **Database**: MySQL 8.0+ / MariaDB 10.4+
- **Aset Frontend**: **SUDAH DI-COMPILE SIAP PAKAI** di folder `public/build/`. Server **TIDAK PERLU** menginstall Node.js / NPM.
- **Akun Super Admin Default**:
  - Email: `m.irhamauliaq@gmail.com` atau `humas.amiktarunaprobolinggo@gmail.com`
  - URL Login: `/login` (Pendaftaran publik `/register` dinonaktifkan demi keamanan).
- **Gelar Resmi Lulusan**: Telah diseragamkan menjadi **A.Md.** (Ahli Madya D3).
- **Upload File**: Mendukung file `.pdf, .doc, .docx` hingga **30 MB** (Brosur PMB, Dokumen Kurikulum, RPS, dll).

---

## 📦 OPSI A: Deploy ke Shared Hosting / cPanel (Metode Paling Mudah)

Struktur yang direkomendasikan adalah **memisahkan file core Laravel di luar `public_html`** agar file `.env` dan sistem inti tidak dapat diakses langsung oleh publik dari browser.

### Langkah 1: Persiapan File ZIP
1. Kompres seluruh folder proyek ini ke dalam file `.zip` (misal: `amik_source.zip`).
2. *Pengecualian*: Folder `node_modules` **tidak perlu disertakan** untuk menghemat ukuran file zip. Folder `vendor`, `public/build`, dan `public/uploads` **wajib disertakan**.

### Langkah 2: Upload ke cPanel File Manager
1. Login ke cPanel hosting kampus.
2. Buka **File Manager**, arahkan ke direktori root home user (sejajar dengan folder `public_html`).
3. Buat folder baru, misalnya bernama `amik_core`.
4. Upload file `amik_source.zip` ke dalam folder `amik_core/` lalu ekstrak (**Extract**).
5. Masuk ke `amik_core/public/`, pilih seluruh isi filenya (termasuk folder `build`, `uploads`, file `.htaccess`, dan `index.php`), lalu pindahkan (**Move**) seluruh isinya ke dalam folder `public_html/`.

### Langkah 3: Penyesuaian Path di `public_html/index.php`
Buka file `public_html/index.php` di cPanel, sesuaikan 2 baris path berikut agar mengarah ke folder `amik_core`:
```php
require __DIR__.'/../amik_core/vendor/autoload.php';

$app = require_once __DIR__.'/../amik_core/bootstrap/app.php';
```

### Langkah 4: Pembuatan Database & File `.env`
1. Di cPanel, buka menu **MySQL Databases**:
   - Buat database baru (contoh: `u12345_amik`).
   - Buat user database baru dan buat password yang kuat.
   - Sambungkan user ke database dengan mencentang **All Privileges**.
2. Masuk ke folder `amik_core/`, buat atau edit file `.env` (bisa salin dari `.env.example`).
3. Sesuaikan bagian database dan URL:
   ```env
   APP_NAME="AMIK Taruna Probolinggo"
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=https://nama-domain-anda.ac.id

   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=u12345_amik
   DB_USERNAME=u12345_dbuser
   DB_PASSWORD=password_db_yang_dibuat
   ```

### Langkah 5: Import Database
- Buka **phpMyAdmin** di cPanel.
- Pilih database yang baru dibuat.
- Klik tab **Import**, pilih file backup `.sql` database lokal, lalu klik **Go / Kirim**.
*(Atau jika cPanel memiliki akses menu **Terminal**, cukup jalankan: `cd ~/amik_core && php artisan migrate --force`).*

### Langkah 6: Hak Akses Folder (File Permissions)
Pastikan folder-folder berikut memiliki izin tulis (*Writable*):
- `amik_core/storage/` -> `775` (atau `755`)
- `amik_core/bootstrap/cache/` -> `775` (atau `755`)
- `public_html/uploads/` -> `775` (atau `755`)

---

## 🖥️ OPSI B: Deploy ke VPS Linux (Ubuntu / Nginx / Apache)

Jika dihosting pada VPS pribadi institusi:

```bash
# 1. Pindah ke direktori web
cd /var/www/
git clone <repository_url> profil_amik
cd profil_amik

# 2. Pasang dependencies PHP (produksi)
composer install --optimize-autoloader --no-dev

# 3. Setup environment & Key
cp .env.example .env
nano .env # Atur DB_DATABASE, DB_USERNAME, DB_PASSWORD, dan APP_URL
php artisan key:generate

# 4. Migrasi Database
php artisan migrate --force

# 5. Storage Link & Permission
php artisan storage:link
sudo chown -R www-data:www-data storage bootstrap/cache public/uploads
sudo chmod -R 775 storage bootstrap/cache public/uploads

# 6. Cache Produksi
php artisan optimize
```

---

## ⚙️ Pengaturan PHP Wajib di Hosting (Untuk Upload Dokumen 30MB)

Karena sistem mengakomodasi upload berkas PDF/DOCX brosur PMB dan kurikulum hingga **30 MB**, mohon pastikan nilai `php.ini` pada hosting telah dinaikkan:

1. Di cPanel: Buka menu **Select PHP Version** -> Tab **Options**.
2. Sesuaikan nilai berikut:
   - `upload_max_filesize` = **32M** (atau lebih)
   - `post_max_size` = **36M** (harus lebih besar dari upload_max_filesize)
   - `memory_limit` = **256M**
   - `max_execution_time` = **300**

---

## 🛡️ Cara Penggunaan Sistem Hak Akses Akun untuk Dosen / Admin

Setelah web berhasil online:
1. Login ke `/login` menggunakan akun **Super Admin**.
2. Di sidebar kiri paling bawah terdapat menu **"Sistem & Hak Akses"**:
   - **Kelola Pengguna (`/admin/users`)**:
     - Anda dapat menambahkan akun baru untuk dosen, staf BAAK, panitia PMB, atau staf humas.
     - Setiap akun dapat dipilih perannya (**Super Admin** atau **Admin Staf**).
     - Untuk Admin Staf, Anda cukup **mencentang menu apa saja yang boleh dibuka** (misal: panitia PMB hanya diberi centang menu *PMB & Formulir* dan *Berita PMB*). Menu lain otomatis disembunyikan dan di-lock secara aman.
   - **Log Aktivitas (`/admin/activity-logs`)**:
     - Halaman khusus bagi Anda selaku Super Admin untuk mengaudit seluruh riwayat login, logout, penambahan, pengeditan, atau penghapusan data kampus beserta waktu, nama staf, dan alamat IP-nya.

---

## ❓ FAQ & Troubleshooting Cepat

| Kendala | Penyebab | Solusi |
|---|---|---|
| Halaman blank putih / Error 500 | `APP_KEY` kosong atau permission `storage/` terkunci | Buka `.env`, pastikan `APP_KEY` sudah terisi (`php artisan key:generate`). Pastikan folder `storage/` dan `bootstrap/cache/` writable (`chmod 775`). |
| File / Gambar Berita 404 | Folder uploads belum dipindahkan | Pastikan folder `uploads` berada di dalam webroot (`public_html/uploads`). |
| Error akses ditolak (403) di admin | Akun staf belum diberi izin | Login dengan akun Super Admin, masuk ke menu *Kelola Pengguna*, lalu centang izin menu untuk akun terkait. |
| Tombol/style CSS tidak rapi | Aset build belum ter-upload | Pastikan folder `public/build` ter-upload utuh (berisi manifest.json dan subfolder assets). |

---
*Dokumen ini dibuat otomatis sebagai panduan serah terima proyek AMIK Taruna Probolinggo.*
