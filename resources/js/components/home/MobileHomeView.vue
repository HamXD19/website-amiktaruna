<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue';

const props = defineProps({
  setting: {
    type: Object,
    default: () => ({})
  },
  beritas: {
    type: Array,
    default: () => []
  },
  programStudis: {
    type: Array,
    default: () => []
  },
  pengumuman: {
    type: Array,
    default: () => []
  }
});

// Banner Slider state
const currentSlide = ref(0);
let slideInterval = null;

const banners = [
  {
    title: 'Penerimaan Mahasiswa Baru',
    highlight: 'TA 2024/2025',
    desc: 'Jalur Beasiswa KIP & Prestasi Akademik. Siapkan karir digital Anda!',
    badge: 'PMB DIBUKA',
    link: '/pmb',
    btnText: 'Daftar Sekarang',
    gradient: 'from-[#063820] via-[#042817] to-[#02150c]',
    accentColor: 'text-emerald-300',
    btnBg: 'bg-emerald-500 hover:bg-emerald-400 text-black',
    icon: 'fas fa-user-graduate'
  },
  {
    title: 'Program Studi Vokasi D3',
    highlight: 'Gelar Resmi A.Md.',
    desc: 'Kurikulum praktis berbasis industri IT dengan sertifikasi kompetensi BNSP.',
    badge: 'AKREDITASI BAIK',
    link: '/akademik',
    btnText: 'Lihat Program Studi',
    gradient: 'from-[#083344] via-[#062430] to-[#02131a]',
    accentColor: 'text-cyan-300',
    btnBg: 'bg-cyan-500 hover:bg-cyan-400 text-black',
    icon: 'fas fa-laptop-code'
  },
  {
    title: 'Pusat Dokumen Resmi',
    highlight: 'Transparansi Akademik',
    desc: 'Unduh kurikulum, pedoman akademik, modul, dan RPS per program studi.',
    badge: 'DOWNLOAD DOKUMEN',
    link: '/dokumen',
    btnText: 'Buka Dokumen',
    gradient: 'from-[#2e1d05] via-[#201404] to-[#110a02]',
    accentColor: 'text-amber-300',
    btnBg: 'bg-amber-500 hover:bg-amber-400 text-black',
    icon: 'fas fa-file-pdf'
  }
];

const nextSlide = () => {
  currentSlide.value = (currentSlide.value + 1) % banners.length;
};

const prevSlide = () => {
  currentSlide.value = (currentSlide.value - 1 + banners.length) % banners.length;
};

onMounted(() => {
  slideInterval = setInterval(nextSlide, 5000);
});

onUnmounted(() => {
  if (slideInterval) clearInterval(slideInterval);
});

// 8 Main Services (Grid 4x2)
const mainServices = [
  {
    id: 'pmb',
    label: 'PMB Online',
    subtitle: 'Daftar Mahasiswa',
    href: '/pmb',
    icon: 'fas fa-user-plus',
    bg: 'bg-gradient-to-br from-emerald-500 to-teal-700',
    shadow: 'shadow-emerald-900/40',
    badge: 'Baru'
  },
  {
    id: 'prodi',
    label: 'Prodi D3',
    subtitle: 'Gelar A.Md.',
    href: '/akademik',
    icon: 'fas fa-graduation-cap',
    bg: 'bg-gradient-to-br from-cyan-500 to-blue-700',
    shadow: 'shadow-cyan-900/40'
  },
  {
    id: 'dokumen',
    label: 'Dokumen',
    subtitle: 'RPS & Kurikulum',
    href: '/dokumen',
    icon: 'fas fa-file-pdf',
    bg: 'bg-gradient-to-br from-amber-500 to-orange-700',
    shadow: 'shadow-amber-900/40'
  },
  {
    id: 'profil',
    label: 'Profil',
    subtitle: 'Tentang Kampus',
    href: '/tentang',
    icon: 'fas fa-university',
    bg: 'bg-gradient-to-br from-blue-500 to-indigo-700',
    shadow: 'shadow-blue-900/40'
  },
  {
    id: 'dosen',
    label: 'Dosen',
    subtitle: 'Tenaga Pengajar',
    href: '/tentang#struktur',
    icon: 'fas fa-chalkboard-teacher',
    bg: 'bg-gradient-to-br from-purple-500 to-violet-800',
    shadow: 'shadow-purple-900/40'
  },
  {
    id: 'alumni',
    label: 'Alumni',
    subtitle: 'Tracer Study',
    href: '/alumni',
    icon: 'fas fa-user-check',
    bg: 'bg-gradient-to-br from-teal-500 to-emerald-700',
    shadow: 'shadow-teal-900/40'
  },
  {
    id: 'lppm',
    label: 'LPPM Riset',
    subtitle: 'Publikasi Ilmiah',
    href: '/lppm',
    icon: 'fas fa-flask',
    bg: 'bg-gradient-to-br from-rose-500 to-pink-700',
    shadow: 'shadow-rose-900/40'
  },
  {
    id: 'aspirasi',
    label: 'Aspirasi',
    subtitle: 'Kritik & Saran',
    href: '/kritik-saran',
    icon: 'fas fa-comment-dots',
    bg: 'bg-gradient-to-br from-slate-600 to-slate-800',
    shadow: 'shadow-slate-900/40'
  }
];

// Fallback program studi if empty
const defaultPrograms = [
  {
    id: 1,
    nama_prodi: 'Manajemen Informatika',
    slug: 'manajemen-informatika',
    akreditasi: 'Baik',
    deskripsi: 'Penguasaan sistem informasi bisnis, rekayasa proses, dan aplikasi korporasi.',
    jenjang: 'Diploma 3 (D3)',
    gelar: 'A.Md.'
  },
  {
    id: 2,
    nama_prodi: 'Teknik Komputer',
    slug: 'teknik-komputer',
    akreditasi: 'Baik',
    deskripsi: 'Spesialisasi rekayasa jaringan, IoT, cloud computing, dan hardware maintenance.',
    jenjang: 'Diploma 3 (D3)',
    gelar: 'A.Md.'
  }
];

const displayProdis = computed(() => {
  if (props.programStudis && props.programStudis.length > 0) {
    return props.programStudis;
  }
  return defaultPrograms;
});

// Format date helper
const formatDate = (dateStr) => {
  if (!dateStr) return '';
  const d = new Date(dateStr);
  if (isNaN(d.getTime())) return dateStr;
  return d.toLocaleDateString('id-ID', {
    day: 'numeric',
    month: 'short',
    year: 'numeric'
  });
};

// Top 4 latest news
const latestNews = computed(() => {
  if (!props.beritas || props.beritas.length === 0) return [];
  return props.beritas.slice(0, 4);
});

// Broken image tracker
const brokenImages = ref(new Set());
const onImgError = (id) => {
  brokenImages.value.add(id);
};

// WhatsApp clean link
const whatsappUrl = computed(() => {
  const rawNumber = props.setting?.whatsapp || props.setting?.no_hp || '6281234567890';
  const cleanNumber = rawNumber.replace(/[^0-9]/g, '');
  const finalNumber = cleanNumber.startsWith('0') ? '62' + cleanNumber.slice(1) : cleanNumber;
  return `https://wa.me/${finalNumber}?text=Halo%20Admin%20AMIK%20Taruna,%20saya%20ingin%20bertanya%20seputar%20pendaftaran%20dan%20informasi%20akademik.`;
});
</script>

<template>
  <div class="mobile-app-shell bg-[#031d11] min-h-screen text-slate-100 pb-20 pt-16">
    
    <!-- 1. Top Identity & Greeting Card (Like PLN Sengkang / Banking App) -->
    <div class="px-4 pt-3 pb-2">
      <div class="bg-gradient-to-r from-[#062c1b] to-[#041f13] rounded-2xl p-4 border border-emerald-500/25 shadow-lg relative overflow-hidden">
        <!-- Background Ambient Glow -->
        <div class="absolute -right-8 -top-8 w-28 h-28 bg-emerald-500/10 rounded-full blur-2xl pointer-events-none"></div>

        <div class="flex items-center justify-between relative z-10">
          <div class="flex items-center gap-3">
            <img
              v-if="setting?.logo"
              :src="'/uploads/' + setting.logo"
              alt="Logo Kampus"
              class="w-11 h-11 object-contain rounded-xl p-1 bg-emerald-950 border border-emerald-500/40 shadow-sm"
              width="44"
              height="44"
              loading="eager"
              fetchpriority="high"
              @error="(e) => e.target.style.display = 'none'"
            />
            <div>
              <div class="flex items-center gap-1.5">
                <span class="text-xs font-bold text-white tracking-wide uppercase">
                  {{ setting?.nama_website || 'AMIK Taruna' }}
                </span>
                <span class="inline-flex items-center text-[10px] text-emerald-400 bg-emerald-950/80 px-1.5 py-0.2 rounded border border-emerald-500/30 font-semibold">
                  <i class="fas fa-check-circle text-[9px] mr-1 text-emerald-400"></i>Terakreditasi B
                </span>
              </div>
              <p class="text-[11px] text-slate-300 mt-0.5 font-medium">
                Sistem Informasi & Portal Sivitas Digital
              </p>
            </div>
          </div>

          <!-- Quick Portal Sivitas Link -->
          <a
            href="/login"
            class="w-9 h-9 rounded-xl bg-emerald-950/90 border border-emerald-500/40 text-emerald-400 flex items-center justify-center hover:bg-emerald-900 transition active:scale-95 shadow-sm"
            title="Login Portal"
            aria-label="Login Portal"
          >
            <i class="fas fa-user-lock text-sm"></i>
          </a>
        </div>

        <!-- Quick Search Trigger Bar -->
        <a
          href="/berita"
          class="mt-3.5 flex items-center gap-2.5 px-3.5 py-2.5 rounded-xl bg-[#02130b]/80 border border-emerald-500/20 text-slate-400 hover:text-slate-200 transition text-xs"
        >
          <i class="fas fa-search text-emerald-400 text-xs"></i>
          <span class="flex-1 truncate">Cari info PMB, prodi D3, pengumuman...</span>
          <span class="text-[10px] bg-emerald-950/80 text-emerald-400 px-2 py-0.5 rounded border border-emerald-500/30">Cari</span>
        </a>
      </div>
    </div>

    <!-- 2. Promo Banner Carousel (Native Mobile Slider) -->
    <div class="px-4 py-2">
      <div class="relative overflow-hidden rounded-2xl border border-emerald-500/25 shadow-xl">
        <!-- Slides Container -->
        <div
          class="flex transition-transform duration-500 ease-out"
          :style="{ transform: `translateX(-${currentSlide * 100}%)` }"
        >
          <div
            v-for="(banner, index) in banners"
            :key="'banner-' + index"
            class="min-w-full relative p-5 bg-gradient-to-br"
            :class="banner.gradient"
          >
            <!-- Decorative badge -->
            <div class="flex items-center justify-between mb-2">
              <span class="text-[10px] font-extrabold tracking-wider uppercase px-2 py-0.5 rounded-md bg-white/10 text-white border border-white/15">
                {{ banner.badge }}
              </span>
              <div class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center text-white/80">
                <i :class="banner.icon" class="text-xs"></i>
              </div>
            </div>

            <h3 class="text-base font-bold text-white leading-tight">
              {{ banner.title }}
            </h3>
            <p class="text-xs font-semibold mt-0.5" :class="banner.accentColor">
              {{ banner.highlight }}
            </p>
            <p class="text-[11px] text-slate-300 mt-1 line-clamp-2 leading-relaxed">
              {{ banner.desc }}
            </p>

            <div class="mt-3.5 flex items-center justify-between">
              <a
                :href="banner.link"
                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold transition shadow-sm active:scale-95"
                :class="banner.btnBg"
              >
                <span>{{ banner.btnText }}</span>
                <i class="fas fa-arrow-right text-[10px]"></i>
              </a>

              <span class="text-[10px] text-slate-400 font-mono">
                {{ index + 1 }} / {{ banners.length }}
              </span>
            </div>
          </div>
        </div>

        <!-- Slider Dot Indicators -->
        <div class="absolute bottom-2 right-4 flex items-center gap-1.5 z-10 pointer-events-none">
          <span
            v-for="(_, idx) in banners"
            :key="'dot-' + idx"
            class="h-1.5 rounded-full transition-all duration-300"
            :class="currentSlide === idx ? 'w-5 bg-emerald-400' : 'w-1.5 bg-white/30'"
          ></span>
        </div>
      </div>
    </div>

    <!-- 3. Announcement Ticker Badge -->
    <div class="px-4 py-1">
      <a
        href="/pmb"
        class="flex items-center gap-2 px-3 py-2 rounded-xl bg-gradient-to-r from-emerald-950/90 to-[#042416] border border-emerald-500/30 text-xs shadow-sm hover:border-emerald-400/50 transition"
      >
        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping shrink-0"></span>
        <span class="text-[10px] font-extrabold uppercase tracking-wider text-emerald-400 shrink-0">
          INFO PMB:
        </span>
        <span class="text-[11px] text-slate-200 truncate flex-1 font-medium">
          Pendaftaran Gelombang 2 Tahun 2024/2025 telah dibuka! Beasiswa KIP Kuliah siap diajukan.
        </span>
        <i class="fas fa-chevron-right text-[10px] text-emerald-400/80 shrink-0"></i>
      </a>
    </div>

    <!-- 3b. Satgas PPKS Safe Space Card -->
    <div class="px-4 py-1.5">
      <a
        href="/ppks"
        class="flex items-center justify-between p-3 rounded-2xl bg-gradient-to-r from-emerald-950/80 via-[#072418] to-red-950/40 border border-emerald-500/30 shadow-md hover:border-emerald-400/50 transition active:scale-98"
      >
        <div class="flex items-center gap-2.5">
          <div class="w-8 h-8 rounded-xl bg-red-500/20 text-red-400 border border-red-500/35 flex items-center justify-center text-xs shrink-0">
            <i class="fas fa-shield-alt"></i>
          </div>
          <div class="leading-tight text-left">
            <span class="text-xs font-bold block text-white">Layanan Satgas PPKS</span>
            <span class="text-[10px] text-slate-300 block">Pelaporan Rahasia Kekerasan Seksual &amp; Dokumen SOP</span>
          </div>
        </div>
        <span class="text-[10px] font-bold text-emerald-400 px-2 py-0.5 rounded-lg bg-emerald-950 border border-emerald-500/30 flex items-center gap-1 shrink-0">
          <span>Akses</span>
          <i class="fas fa-arrow-right text-[8px]"></i>
        </span>
      </a>
    </div>

    <!-- 4. 8-Grid Feature / Quick Actions ("Menu Layanan Utama") -->
    <div class="px-4 pt-4 pb-2">
      <div class="flex items-center justify-between mb-3 px-1">
        <h2 class="text-xs font-bold uppercase tracking-wider text-slate-300 flex items-center gap-1.5">
          <i class="fas fa-th-large text-emerald-400 text-xs"></i>
          <span>Layanan Utama</span>
        </h2>
        <span class="text-[10px] text-slate-400">Akses Cepat 24/7</span>
      </div>

      <!-- 4 Columns x 2 Rows Grid -->
      <div class="grid grid-cols-4 gap-2.5">
        <a
          v-for="service in mainServices"
          :key="service.id"
          :href="service.href"
          class="flex flex-col items-center p-2 rounded-xl bg-[#062417]/80 hover:bg-[#08301f] border border-emerald-500/20 hover:border-emerald-500/40 transition-all duration-150 active:scale-95 group text-center"
        >
          <!-- Squircle Icon Box -->
          <div
            class="w-12 h-12 rounded-2xl flex items-center justify-center text-white text-base shadow-md group-hover:scale-105 transition-transform duration-200 relative mb-1.5"
            :class="[service.bg, service.shadow]"
          >
            <i :class="service.icon"></i>
            <!-- Optional Notification Badge -->
            <span
              v-if="service.badge"
              class="absolute -top-1 -right-1 px-1.5 py-0.2 bg-red-500 text-white text-[8px] font-bold rounded-full shadow"
            >
              {{ service.badge }}
            </span>
          </div>

          <span class="text-[11px] font-bold text-white group-hover:text-emerald-300 transition-colors leading-tight line-clamp-1">
            {{ service.label }}
          </span>
          <span class="text-[9px] text-slate-400 mt-0.5 line-clamp-1">
            {{ service.subtitle }}
          </span>
        </a>
      </div>
    </div>

    <!-- 5. Program Studi Vokasi D3 Cards -->
    <div class="px-4 pt-4 pb-2">
      <div class="flex items-center justify-between mb-3 px-1">
        <div class="flex items-center gap-2">
          <div class="w-1.5 h-4 bg-emerald-400 rounded-full"></div>
          <h2 class="text-sm font-bold text-white">Program Studi Unggulan</h2>
        </div>
        <a href="/akademik" class="text-xs text-emerald-400 font-semibold hover:underline flex items-center gap-1">
          <span>Semua Prodi</span>
          <i class="fas fa-chevron-right text-[9px]"></i>
        </a>
      </div>

      <div class="space-y-2.5">
        <div
          v-for="prodi in displayProdis"
          :key="'prodi-' + prodi.id"
          class="p-3.5 rounded-2xl bg-gradient-to-br from-[#062819] to-[#041d12] border border-emerald-500/25 shadow-md hover:border-emerald-500/45 transition"
        >
          <div class="flex items-start justify-between gap-2">
            <div>
              <div class="flex flex-wrap items-center gap-1.5 mb-1">
                <!-- IMPORTANT: Degree title is strictly A.Md. per user request -->
                <span class="text-[10px] font-extrabold px-2 py-0.5 rounded-full bg-emerald-500/20 text-emerald-300 border border-emerald-500/35">
                  Jenjang D3 • Gelar A.Md.
                </span>
                <span class="text-[10px] font-semibold px-2 py-0.5 rounded-full bg-cyan-500/20 text-cyan-300 border border-cyan-500/35">
                  Akreditasi {{ prodi.akreditasi || 'Baik' }}
                </span>
              </div>
              <h3 class="text-sm font-bold text-white">
                {{ prodi.nama_prodi }}
              </h3>
            </div>
            <div class="w-8 h-8 rounded-xl bg-emerald-950/80 border border-emerald-500/30 text-emerald-400 flex items-center justify-center shrink-0">
              <i class="fas fa-laptop-code text-xs"></i>
            </div>
          </div>

          <p class="text-xs text-slate-300 mt-1.5 line-clamp-2 leading-relaxed font-normal">
            {{ prodi.deskripsi || 'Program studi vokasi berorientasi kompetensi terapan, teknologi informasi modern, dan kesiapan karir profesional.' }}
          </p>

          <div class="mt-3 pt-2.5 border-t border-emerald-500/15 flex items-center justify-between">
            <div class="flex items-center gap-3 text-[10px] text-slate-400">
              <span class="flex items-center gap-1">
                <i class="fas fa-file-pdf text-emerald-400"></i> RPS Lengkap
              </span>
              <span class="flex items-center gap-1">
                <i class="fas fa-certificate text-cyan-400"></i> BNSP
              </span>
            </div>

            <a
              :href="'/akademik/' + (prodi.slug || prodi.id)"
              class="inline-flex items-center gap-1 text-xs font-bold text-emerald-300 hover:text-emerald-200 transition"
            >
              <span>Kurikulum</span>
              <i class="fas fa-arrow-right text-[10px]"></i>
            </a>
          </div>
        </div>
      </div>
    </div>

    <!-- 6. Warta & Pengumuman Kampus (Mobile Feed) -->
    <div class="px-4 pt-4 pb-2">
      <div class="flex items-center justify-between mb-3 px-1">
        <div class="flex items-center gap-2">
          <div class="w-1.5 h-4 bg-emerald-400 rounded-full"></div>
          <h2 class="text-sm font-bold text-white">Warta & Kabar Kampus</h2>
        </div>
        <a href="/berita" class="text-xs text-emerald-400 font-semibold hover:underline flex items-center gap-1">
          <span>Lihat Semua</span>
          <i class="fas fa-chevron-right text-[9px]"></i>
        </a>
      </div>

      <div class="space-y-2.5">
        <a
          v-for="item in latestNews"
          :key="'news-' + item.id"
          :href="'/berita/' + (item.slug || item.id)"
          class="flex items-center gap-3 p-3 rounded-2xl bg-[#062617]/70 hover:bg-[#062617] border border-emerald-500/20 hover:border-emerald-500/40 transition active:scale-98 group"
        >
          <!-- Thumbnail -->
          <div class="w-20 h-20 rounded-xl overflow-hidden bg-emerald-950/80 border border-emerald-500/20 shrink-0 relative flex items-center justify-center">
            <img
              v-if="item.gambar && !brokenImages.has(item.id)"
              :src="'/uploads/' + item.gambar"
              :alt="item.judul"
              class="w-full h-full object-cover group-hover:scale-105 transition duration-300"
              @error="() => onImgError(item.id)"
            />
            <div v-else class="text-emerald-500/60 flex flex-col items-center">
              <i class="far fa-newspaper text-xl mb-1"></i>
              <span class="text-[8px] font-bold uppercase">AMIK</span>
            </div>
          </div>

          <!-- News Details -->
          <div class="flex-1 min-w-0">
            <div class="flex items-center gap-1.5 mb-1">
              <span class="text-[9px] font-bold px-1.5 py-0.2 rounded bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 uppercase truncate">
                {{ item.kategori || 'Warta Kampus' }}
              </span>
              <span class="text-[10px] text-slate-400 font-mono">
                {{ formatDate(item.created_at || item.tanggal) }}
              </span>
            </div>

            <h4 class="text-xs font-bold text-white group-hover:text-emerald-300 transition-colors line-clamp-2 leading-snug">
              {{ item.judul }}
            </h4>

            <p class="text-[10px] text-slate-400 mt-1 line-clamp-1">
              {{ item.ringkasan || 'Informasi dan warta terkini dari sivitas akademika kampus.' }}
            </p>
          </div>
        </a>
      </div>
    </div>

    <!-- 7. WhatsApp Consultation & Helpdesk Card -->
    <div class="px-4 pt-4 pb-2">
      <div class="rounded-2xl p-4 bg-gradient-to-r from-[#032b17] via-[#053820] to-[#032b17] border border-emerald-500/35 shadow-lg relative overflow-hidden">
        <div class="flex items-start gap-3">
          <div class="w-10 h-10 rounded-2xl bg-emerald-500 text-black flex items-center justify-center text-lg shrink-0 shadow-lg shadow-emerald-500/25">
            <i class="fab fa-whatsapp"></i>
          </div>
          <div class="flex-1">
            <h3 class="text-xs font-bold text-white">Butuh Bantuan PMB atau Akademik?</h3>
            <p class="text-[11px] text-emerald-200/90 mt-0.5 leading-relaxed">
              Konsultasikan syarat pendaftaran, biaya kuliah, atau jadwal seleksi langsung dengan Helpdesk kami.
            </p>

            <a
              :href="whatsappUrl"
              target="_blank"
              rel="noopener noreferrer"
              class="mt-2.5 inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-emerald-500 text-black font-bold text-xs hover:bg-emerald-400 transition shadow-sm active:scale-95"
            >
              <i class="fab fa-whatsapp text-sm"></i>
              <span>Chat WhatsApp Sekarang</span>
            </a>
          </div>
        </div>
      </div>
    </div>

    <!-- 8. Campus Location & Touch Card -->
    <div class="px-4 pt-3 pb-6">
      <div class="p-3.5 rounded-2xl bg-[#041a10] border border-emerald-500/20 text-xs text-slate-300 space-y-2">
        <div class="flex items-center gap-2 text-white font-bold">
          <i class="fas fa-map-marker-alt text-emerald-400"></i>
          <span>Kampus AMIK Taruna</span>
        </div>
        <p class="text-[11px] text-slate-400 leading-relaxed">
          {{ setting?.alamat || 'Jl. Jenderal Sudirman, Sengkang, Kabupaten Wajo, Sulawesi Selatan' }}
        </p>
        <div class="flex items-center justify-between pt-1 text-[11px]">
          <span class="text-slate-400">
            <i class="fas fa-phone-alt text-emerald-400 mr-1"></i> {{ setting?.no_hp || '0812-3456-7890' }}
          </span>
          <a
            :href="setting?.maps_embed ? '#' : 'https://maps.google.com/?q=' + encodeURIComponent(setting?.alamat || 'AMIK Taruna')"
            target="_blank"
            class="text-emerald-400 font-bold hover:underline"
          >
            Buka Peta <i class="fas fa-external-link-alt text-[9px] ml-0.5"></i>
          </a>
        </div>
      </div>
    </div>

  </div>
</template>

<style scoped>
.mobile-app-shell {
  /* Prevent horizontal stretch & provide smooth scrolling */
  max-width: 100vw;
  overflow-x: hidden;
}
</style>
