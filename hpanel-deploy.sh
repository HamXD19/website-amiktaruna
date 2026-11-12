#!/bin/bash
# ========================================================
# Script Deployment di Terminal / SSH Hostinger hPanel
# ========================================================

echo "🚀 Memulai proses update di Hostinger hPanel..."

# Masuk ke direktori web (sesuaikan jika di subfolder)
cd ~/public_html || exit

# 1. Tarik update terbaru dari GitHub
echo "📥 Menarik kode terbaru dari GitHub..."
git fetch origin main
git reset --hard origin/main

# 2. Siapkan folder privat yang aman jika belum ada
mkdir -p storage/app/private/ppks
mkdir -p storage/framework/{sessions,views,cache}
chmod -R 775 storage bootstrap/cache

# 3. Jalankan migrasi database jika ada tabel baru
echo "🗄️ Menjalankan migrasi database..."
php artisan migrate --force

# 4. Pastikan symlink storage terpasang
echo "🔗 Mengecek symbolic link storage..."
php artisan storage:link 2>/dev/null

# 5. Bersihkan dan optimalkan cache Laravel untuk performa maksimal
echo "⚡ Mengoptimalkan cache sistem..."
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache 2>/dev/null

echo "✅ Berhasil! Aplikasi di Hostinger hPanel sudah aktif dan optimal dengan versi terbaru."
