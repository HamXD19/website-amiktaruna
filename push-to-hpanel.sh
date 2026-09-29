#!/bin/bash
# ========================================================
# Script Push dari Komputer Lokal ke GitHub (untuk hPanel)
# ========================================================

echo "=========================================="
echo "🚀 PROSES PUSH UPDATE KE GITHUB / HPANEL"
echo "=========================================="

# 1. Compile aset Vite terbaru
echo "📦 [1/3] Meng-compile aset frontend..."
npm run build

# 2. Tambahkan semua perubahan
echo "📝 [2/3] Menyiapkan commit git..."
git add .

COMMIT_MSG="$1"
if [ -z "$COMMIT_MSG" ]; then
    read -p "Masukkan pesan commit (atau tekan Enter): " INPUT_MSG
    COMMIT_MSG="${INPUT_MSG:-update: perbaikan dan pembaruan sistem}"
fi

git commit -m "$COMMIT_MSG"

# 3. Push ke remote repository
echo "📤 [3/3] Mengirim (push) perubahan ke branch main..."
git push origin main

echo ""
echo "=========================================="
echo "✅ BERHASIL DI-PUSH KE GITHUB!"
echo "=========================================="
echo "Langkah selanjutnya di Hostinger hPanel:"
echo "1. Buka hPanel -> Menu 'Git'"
echo "2. Klik tombol 'Deploy' pada repository website-amiktaruna"
echo "   (Atau jika via Terminal/SSH hPanel, jalankan: bash hpanel-deploy.sh)"
echo "=========================================="
