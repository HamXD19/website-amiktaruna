#!/bin/bash
# ==============================================================================
# SCRIPT DEPLOY OTOMATIS KE SERVER VIA SSH (HOSTINGER HPANEL / VPS / CPANEL)
# Website Profil & CMS AMIK Taruna Probolinggo
# ==============================================================================

set -e

# Warna Terminal
GREEN='\033[0;32m'
BLUE='\033[0;34m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
CYAN='\033[0;36m'
BOLD='\033[1m'
NC='\033[0m' # No Color

echo -e "${GREEN}${BOLD}==============================================================================${NC}"
echo -e "${GREEN}${BOLD}🚀 DEPLOYMENT AUTOMATION VIA SSH - AMIK TARUNA PROBOLINGGO${NC}"
echo -e "${GREEN}${BOLD}==============================================================================${NC}"

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
CONFIG_FILE="${SCRIPT_DIR}/.deploy.env"

# ------------------------------------------------------------------------------
# 1. LOAD ATAU MINTA KONFIGURASI SSH
# ------------------------------------------------------------------------------
if [ -f "$CONFIG_FILE" ]; then
    echo -e "${CYAN}ℹ️  Memuat konfigurasi dari ${BOLD}.deploy.env${NC}..."
    # shellcheck source=/dev/null
    source "$CONFIG_FILE"
fi

SSH_HOST="${SSH_HOST:-145.79.25.211}"
SSH_PORT="${SSH_PORT:-65002}"
SSH_USER="${SSH_USER:-u909539567}"
REMOTE_PATH="${REMOTE_PATH:-/home/u909539567/domains/amiktaruna.ac.id/public_html}"
SSH_KEY_PATH="${SSH_KEY_PATH:-}"

if [ -z "$SSH_HOST" ] || [ -z "$SSH_USER" ]; then
    echo -e "\n${YELLOW}⚠️  Konfigurasi SSH belum lengkap. Silakan masukkan parameter koneksi server Anda:${NC}"
    
    read -rp "1. Host / IP Server (misal: connect.hostinger.com): " INPUT_HOST
    SSH_HOST="${INPUT_HOST:-$SSH_HOST}"
    
    read -rp "2. Port SSH [Default: 65002 untuk Hostinger, 22 untuk VPS]: " INPUT_PORT
    SSH_PORT="${INPUT_PORT:-65002}"
    
    read -rp "3. Username SSH (misal: u123456789 atau root): " INPUT_USER
    SSH_USER="${INPUT_USER:-$SSH_USER}"
    
    read -rp "4. Direktori Website di Server [Default: public_html]: " INPUT_PATH
    REMOTE_PATH="${INPUT_PATH:-public_html}"

    read -rp "Simpan konfigurasi ini ke file .deploy.env? (y/N): " SAVE_CONF
    if [[ "$SAVE_CONF" =~ ^[Yy]$ ]]; then
        cat <<EOF > "$CONFIG_FILE"
# Konfigurasi SSH Deployment Otomatis (Aman & di-ignore Git)
SSH_HOST="${SSH_HOST}"
SSH_PORT="${SSH_PORT}"
SSH_USER="${SSH_USER}"
REMOTE_PATH="${REMOTE_PATH}"
SSH_KEY_PATH="${SSH_KEY_PATH}"
EOF
        chmod 600 "$CONFIG_FILE"
        echo -e "${GREEN}✅ Konfigurasi disimpan ke .deploy.env${NC}"
    fi
fi

if [ -z "$SSH_HOST" ] || [ -z "$SSH_USER" ]; then
    echo -e "${RED}❌ Host dan Username SSH tidak boleh kosong. Deployment dibatalkan.${NC}"
    exit 1
fi

# Opsi SSH Key jika dispesifikasikan
SSH_OPTS="-p ${SSH_PORT}"
if [ -n "$SSH_KEY_PATH" ] && [ -f "$SSH_KEY_PATH" ]; then
    SSH_OPTS="${SSH_OPTS} -i ${SSH_KEY_PATH}"
fi

# ------------------------------------------------------------------------------
# 2. KOMPILASI ASET VITE FRONTEND (LOKAL)
# ------------------------------------------------------------------------------
echo -e "\n${BLUE}${BOLD}[1/4] 📦 Mengompilasi aset frontend (Vite / Tailwind)...${NC}"
if command -v npm &> /dev/null; then
    npm run build
    echo -e "${GREEN}✅ Kompilasi aset frontend selesai.${NC}"
else
    echo -e "${YELLOW}⚠️  npm tidak ditemukan, melewati tahap compile (menggunakan build yang ada).${NC}"
fi

# ------------------------------------------------------------------------------
# 3. PUSH PERUBAHAN KE GITHUB
# ------------------------------------------------------------------------------
echo -e "\n${BLUE}${BOLD}[2/4] 📤 Menyiapkan dan Push perubahan kode ke GitHub...${NC}"
if [ -d ".git" ]; then
    git add .
    
    # Cek apakah ada perubahan yang perlu dicommit
    if ! git diff --cached --quiet; then
        COMMIT_MSG="$1"
        if [ -z "$COMMIT_MSG" ]; then
            read -rp "Masukkan pesan commit (tekan Enter untuk default): " INPUT_COMMIT
            COMMIT_MSG="${INPUT_COMMIT:-update: pembaruan sistem dan keamanan}"
        fi
        git commit -m "$COMMIT_MSG"
        echo -e "${GREEN}✅ Perubahan berhasil di-commit.${NC}"
    else
        echo -e "${CYAN}ℹ️  Tidak ada perubahan file baru yang perlu di-commit.${NC}"
    fi

    echo -e "${CYAN}Mengirim ke remote origin main...${NC}"
    git push origin main
    echo -e "${GREEN}✅ Push ke GitHub berhasil.${NC}"
else
    echo -e "${YELLOW}⚠️  Bukan direktori Git, melewati push GitHub.${NC}"
fi

# ------------------------------------------------------------------------------
# 4. EKSEKUSI PERINTAH DEPLOYMENT DI SERVER REMOTE VIA SSH
# ------------------------------------------------------------------------------
echo -e "\n${BLUE}${BOLD}[3/4] 🌐 Menghubungi Server via SSH (${SSH_USER}@${SSH_HOST}:${SSH_PORT})...${NC}"

SSH_COMMANDS=$(cat << 'REMOTE_SCRIPT'
set -e

# Warna Terminal di Remote
R_GREEN='\033[0;32m'
R_BLUE='\033[0;34m'
R_CYAN='\033[0;36m'
R_NC='\033[0m'

echo -e "${R_CYAN}📁 Masuk ke direktori aplikasi...${R_NC}"
cd "$TARGET_DIR" || { echo "Gagal masuk ke $TARGET_DIR"; exit 1; }

echo -e "${R_BLUE}📥 1. Menarik kode terbaru dari branch main...${R_NC}"
git fetch origin main
git reset --hard origin/main

echo -e "${R_BLUE}🔒 2. Memastikan struktur folder privat dan perizinan...${R_NC}"
mkdir -p storage/app/private/ppks
mkdir -p storage/framework/{sessions,views,cache}
mkdir -p storage/logs
mkdir -p bootstrap/cache
chmod -R 775 storage bootstrap/cache 2>/dev/null || true

echo -e "${R_BLUE}📦 3. Memasang dependensi Composer terbaru...${R_NC}"
composer install --no-dev --optimize-autoloader

echo -e "${R_BLUE}🗄️  4. Menjalankan migrasi database (jika ada)...${R_NC}"
php artisan migrate --force

echo -e "${R_BLUE}🔗 5. Memastikan symbolic link storage...${R_NC}"
php artisan storage:link 2>/dev/null || true

echo -e "${R_BLUE}⚡ 6. Membersihkan dan mengoptimalkan cache Laravel...${R_NC}"
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache 2>/dev/null || true

echo -e "${R_GREEN}✅ SELURUH PROSES UPDATE DI SERVER BERHASIL!${R_NC}"
REMOTE_SCRIPT
)

# Jalankan skrip di remote server
# shellcheck disable=SC2086
ssh -t -o StrictHostKeyChecking=accept-new ${SSH_OPTS} "${SSH_USER}@${SSH_HOST}" "TARGET_DIR='${REMOTE_PATH}' bash -c '${SSH_COMMANDS}'"

# ------------------------------------------------------------------------------
# 5. SELESAI
# ------------------------------------------------------------------------------
echo -e "\n${GREEN}${BOLD}==============================================================================${NC}"
echo -e "${GREEN}${BOLD}🎉 DEPLOYMENT SELESAI DENGAN SUKSES!${NC}"
echo -e "${GREEN}Website AMIK Taruna sudah ter-update di server dengan proteksi keamanan terbaru.${NC}"
echo -e "${GREEN}${BOLD}==============================================================================${NC}\n"
