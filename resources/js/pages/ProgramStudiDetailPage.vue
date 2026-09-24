<script setup>
import { ref, computed } from 'vue';
import AppNavbar from '../components/layout/AppNavbar.vue';
import AppFooter from '../components/layout/AppFooter.vue';
import CtaSection from '../components/home/CtaSection.vue';

const props = defineProps({
  setting: {
    type: Object,
    default: () => ({})
  },
  program: {
    type: Object,
    required: true,
    default: () => ({})
  },
  kategoriDokumen: {
    type: Array,
    default: () => []
  }
});

// Defensive collections
const dokumensList = computed(() => {
  return props.program.dokumens || [];
});

const selectedDokumenKategori = ref('semua');
const searchDokumenQuery = ref('');

// List of available categories for filter tabs
const availableDokumenKategoris = computed(() => {
  if (props.kategoriDokumen && props.kategoriDokumen.length > 0) {
    return props.kategoriDokumen;
  }
  const map = new Map();
  dokumensList.value.forEach(d => {
    if (d.kategori && !map.has(d.kategori)) {
      map.set(d.kategori, {
        slug: d.kategori,
        nama: d.kategori_model?.nama || d.kategori,
        ikon: d.kategori_model?.ikon || '📌',
        warna: d.kategori_model?.warna || 'success'
      });
    }
  });
  return Array.from(map.values());
});

// Category count helper
const getDokumenCountByKategori = (katSlug) => {
  if (katSlug === 'semua') return dokumensList.value.length;
  return dokumensList.value.filter(d => (d.kategori === katSlug || d.kategori_model?.slug === katSlug)).length;
};

// Filtered documents (Client-side reactive search, zero page refresh)
const filteredDokumens = computed(() => {
  let list = dokumensList.value;

  if (selectedDokumenKategori.value !== 'semua') {
    list = list.filter(d => d.kategori === selectedDokumenKategori.value || d.kategori_model?.slug === selectedDokumenKategori.value);
  }

  if (searchDokumenQuery.value.trim() !== '') {
    const q = searchDokumenQuery.value.toLowerCase();
    list = list.filter(d => {
      const matchName = d.nama_dokumen?.toLowerCase().includes(q);
      const matchDesc = d.deskripsi?.toLowerCase().includes(q);
      const matchTahun = d.tahun?.toLowerCase().includes(q);
      const matchKat = d.kategori_model?.nama?.toLowerCase().includes(q);
      return matchName || matchDesc || matchTahun || matchKat;
    });
  }

  return list;
});

// Helper for file type icon and badge styling
const getFileExt = (filename) => {
  if (!filename) return 'pdf';
  return filename.split('.').pop().toLowerCase();
};

const isWordFile = (filename) => {
  const ext = getFileExt(filename);
  return ext === 'doc' || ext === 'docx';
};

const getBadgeClass = (warna) => {
  switch (warna) {
    case 'primary':
      return 'bg-blue-950/70 text-blue-300 border border-blue-500/30';
    case 'success':
      return 'bg-emerald-950/70 text-emerald-300 border border-emerald-500/30';
    case 'warning':
      return 'bg-amber-950/70 text-amber-300 border border-amber-500/30';
    case 'danger':
      return 'bg-rose-950/70 text-rose-300 border border-rose-500/30';
    case 'info':
      return 'bg-cyan-950/70 text-cyan-300 border border-cyan-500/30';
    default:
      return 'bg-emerald-950/70 text-emerald-300 border border-emerald-500/30';
  }
};

// Defensive collections
const profilLulusans = computed(() => {
  return props.program.profil_lulusans || props.program.profilLulusans || [];
});

const fasilitasList = computed(() => {
  return props.program.fasilitas || [];
});

const faqsList = computed(() => {
  return props.program.faqs || [];
});

// Interactive Accordion for FAQ
const activeFaqIndex = ref(0);
const toggleFaq = (index) => {
  activeFaqIndex.value = activeFaqIndex.value === index ? null : index;
};

// Monogram Helper
const getProgramCode = (namaProdi) => {
  if (!namaProdi) return 'D3';
  const clean = namaProdi.toLowerCase();
  if (clean.includes('akuntansi')) return 'SIA';
  if (clean.includes('teknologi')) return 'TI';
  if (clean.includes('sistem')) return 'SI';
  return namaProdi.split(' ').map(w => w[0]).join('').toUpperCase().slice(0, 3);
};

// Fallback icon for facility if none provided
const getFasilitasIcon = (iconStr, index) => {
  if (iconStr && iconStr.trim() !== '') return iconStr;
  const defaults = [
    'fas fa-laptop-code',
    'fas fa-desktop',
    'fas fa-network-wired',
    'fas fa-server',
    'fas fa-microchip',
    'fas fa-database'
  ];
  return defaults[index % defaults.length];
};

// WhatsApp Link
const whatsappUrl = computed(() => {
  const phone = props.setting?.no_wa || props.setting?.telepon || '628123456789';
  const cleanPhone = phone.replace(/[^0-9]/g, '');
  const target = cleanPhone.startsWith('0') ? '62' + cleanPhone.slice(1) : cleanPhone;
  const message = encodeURIComponent(`Halo BAAK AMIK Taruna Probolinggo, saya ingin menanyakan informasi mengenai Program Studi ${props.program?.nama_prodi || 'D3'}.`);
  return `https://wa.me/${target}?text=${message}`;
});

// Image error handling
const imageError = ref(false);
const handleImageError = () => {
  imageError.value = true;
};
</script>

<template>
  <div class="min-h-screen flex flex-col bg-[#fbfcfb] text-slate-800 antialiased selection:bg-[#dcfce7] selection:text-[#14532d]">
    
    <!-- 1. Header / Navbar (Sticky, Grouped Navigation) -->
    <AppNavbar :setting="setting" current-path="/akademik" />

    <main class="flex-1">
      <!-- 2. Hero Detail Header (Editorial Brand Green, Breadcrumbs & Key Meta) -->
      <section class="relative pt-28 pb-14 sm:pt-32 sm:pb-18 lg:pt-36 lg:pb-20 bg-[#052e16] text-white overflow-hidden border-b border-[#14532d]/60">
        <!-- Background Grid Pattern -->
        <div class="absolute inset-0 bg-[linear-gradient(to_right,#ffffff_1px,transparent_1px),linear-gradient(to_bottom,#ffffff_1px,transparent_1px)] bg-[size:3.5rem_3.5rem] [mask-image:radial-gradient(ellipse_70%_60%_at_50%_40%,#000_60%,transparent_100%)] opacity-[0.05] pointer-events-none"></div>

        <!-- Ambient Glow -->
        <div class="absolute -top-20 -left-20 w-96 h-96 bg-[#166534]/30 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-20 -right-20 w-96 h-96 bg-[#15803d]/20 rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
          
          <!-- Breadcrumb Navigation -->
          <nav aria-label="Breadcrumb" class="mb-6 flex flex-wrap items-center gap-2 text-xs font-medium text-emerald-200/75">
            <a href="/" class="hover:text-white transition-colors flex items-center gap-1.5">
              <i class="fas fa-home text-[10px]"></i>
              <span>Beranda</span>
            </a>
            <span class="text-emerald-500/40">/</span>
            <a href="/akademik" class="hover:text-white transition-colors">
              Akademik
            </a>
            <span class="text-emerald-500/40">/</span>
            <span class="text-emerald-300 font-semibold truncate max-w-[200px] sm:max-w-none" aria-current="page">
              {{ program.nama_prodi }}
            </span>
          </nav>

          <div class="max-w-4xl">
            <!-- Eyebrow & Accreditation Badge -->
            <div class="flex flex-wrap items-center gap-2.5 mb-4">
              <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-widest bg-[#14532d]/90 text-[#dcfce7] border border-[#166534] shadow-xs">
                <span class="w-1.5 h-1.5 rounded-full bg-[#4ade80]"></span>
                Program Studi Diploma III
              </span>
              <span v-if="program.akreditasi" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-widest bg-white/10 text-emerald-100 border border-white/15">
                <i class="fas fa-shield-alt text-emerald-300 text-[11px]"></i>
                Akreditasi {{ program.akreditasi }}
              </span>
            </div>

            <!-- Main Heading -->
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white tracking-tight leading-[1.14]">
              {{ program.nama_prodi }}
            </h1>

            <!-- Tagline -->
            <p v-if="program.tagline" class="mt-4 text-base sm:text-lg text-emerald-100/90 leading-relaxed font-medium">
              {{ program.tagline }}
            </p>

            <!-- Quick Specs List -->
            <div class="mt-8 flex flex-wrap items-center gap-3 pt-6 border-t border-emerald-900/60 text-xs text-emerald-200/90">
              <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-[#0a2e1e] border border-[#166534]/70">
                <i class="fas fa-graduation-cap text-emerald-400"></i>
                <span>Gelar: <strong>A.Md.</strong></span>
              </div>
              <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-[#0a2e1e] border border-[#166534]/70">
                <i class="fas fa-clock text-emerald-400"></i>
                <span>Masa Studi: <strong>3 Tahun (6 Semester)</strong></span>
              </div>
              <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-[#0a2e1e] border border-[#166534]/70">
                <i class="fas fa-book-reader text-emerald-400"></i>
                <span>Kurikulum: <strong>Berbasis Vokasi & KKNI</strong></span>
              </div>
            </div>

          </div>

        </div>
      </section>

      <!-- 3. Detail Content Layout (8 Cols Left Content + 4 Cols Sticky Sidebar) -->
      <section class="py-12 sm:py-16 lg:py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-12 items-start">
            
            <!-- LEFT COLUMN: Main Content (8 cols) -->
            <div class="lg:col-span-8 space-y-10 sm:space-y-12">
              
              <!-- 1. Tentang Program Studi -->
              <article class="card rounded-2xl p-6 sm:p-8 lg:p-10 border border-emerald-500/20 shadow-xl">
                <div class="flex items-center gap-3 mb-6">
                  <span class="w-10 h-10 rounded-xl bg-emerald-500/20 text-emerald-300 flex items-center justify-center text-base shrink-0 border border-emerald-500/30">
                    <i class="fas fa-info-circle"></i>
                  </span>
                  <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-emerald-400 block">Profil Utama</span>
                    <h2 class="text-xl sm:text-2xl font-bold text-white tracking-tight">
                      Tentang Program Studi
                    </h2>
                  </div>
                </div>

                <div class="prose prose-slate max-w-none text-base leading-relaxed text-slate-300 whitespace-pre-line">
                  {{ program.deskripsi || 'Program studi vokasi AMIK Taruna Probolinggo dirancang dengan kurikulum aplikatif yang memadukan teori komputasi terapan, praktik laboratorium intensif, dan proyek industri riil guna memastikan kesiapan lulusan memasuki dunia kerja modern.' }}
                </div>
              </article>

              <!-- 2. Visi & Misi Program Studi (Rendered if available) -->
              <section v-if="program.visi || program.misi" class="card rounded-2xl p-6 sm:p-8 lg:p-10 border border-emerald-500/20 shadow-xl">
                <div class="flex items-center gap-3 mb-8">
                  <span class="w-10 h-10 rounded-xl bg-emerald-500/20 text-emerald-300 flex items-center justify-center text-base shrink-0 border border-emerald-500/30">
                    <i class="fas fa-compass"></i>
                  </span>
                  <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-emerald-400 block">Arah Pengembangan</span>
                    <h2 class="text-xl sm:text-2xl font-bold text-white tracking-tight">
                      Visi & Misi Keilmuan
                    </h2>
                  </div>
                </div>

                <div class="space-y-6">
                  <!-- Visi Box -->
                  <div v-if="program.visi" class="p-6 rounded-xl bg-emerald-950/40 border border-emerald-500/25">
                    <span class="inline-flex items-center gap-1.5 text-xs font-bold uppercase tracking-widest text-emerald-300 mb-2.5">
                      <i class="fas fa-eye text-[11px]"></i> Visi Program Studi
                    </span>
                    <p class="text-base sm:text-lg font-medium text-emerald-100 italic leading-relaxed">
                      "{{ program.visi }}"
                    </p>
                  </div>

                  <!-- Misi Box -->
                  <div v-if="program.misi" class="p-6 rounded-xl bg-emerald-950/30 border border-emerald-500/25">
                    <span class="inline-flex items-center gap-1.5 text-xs font-bold uppercase tracking-widest text-emerald-300 mb-2.5">
                      <i class="fas fa-bullseye text-[11px] text-emerald-400"></i> Misi Program Studi
                    </span>
                    <div class="text-sm sm:text-base text-slate-300 leading-relaxed whitespace-pre-line">
                      {{ program.misi }}
                    </div>
                  </div>
                </div>
              </section>

              <!-- 3. Profil Lulusan & Capaian Pembelajaran -->
              <section v-if="profilLulusans.length > 0" class="card rounded-2xl p-6 sm:p-8 lg:p-10 border border-emerald-500/20 shadow-xl">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
                  <div class="flex items-center gap-3">
                    <span class="w-10 h-10 rounded-xl bg-emerald-500/20 text-emerald-300 flex items-center justify-center text-base shrink-0 border border-emerald-500/30">
                      <i class="fas fa-user-graduate"></i>
                    </span>
                    <div>
                      <span class="text-xs font-bold uppercase tracking-wider text-emerald-400 block">Karier & Prospek Kerja</span>
                      <h2 class="text-xl sm:text-2xl font-bold text-white tracking-tight">
                        Profil Lulusan
                      </h2>
                    </div>
                  </div>
                  <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 self-start sm:self-center">
                    <i class="fas fa-check-circle text-[11px]"></i>
                    {{ profilLulusans.length }} Profil Kompetensi
                  </span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                  <div
                    v-for="(profil, idx) in profilLulusans"
                    :key="profil.id || idx"
                    class="p-5 sm:p-6 rounded-xl border border-emerald-500/20 hover:border-emerald-400/50 bg-black/30 hover:bg-emerald-950/60 transition-all duration-300 group hover:shadow-lg"
                  >
                    <div class="w-10 h-10 rounded-lg bg-emerald-500/20 group-hover:bg-[#16a34a] text-emerald-300 group-hover:text-white flex items-center justify-center text-sm font-bold transition-colors mb-4 border border-emerald-500/30">
                      <i class="fas fa-briefcase"></i>
                    </div>
                    <h3 class="text-base font-bold text-white group-hover:text-emerald-300 transition-colors mb-2">
                      {{ profil.judul }}
                    </h3>
                    <p class="text-xs sm:text-sm text-slate-300 leading-relaxed">
                      {{ profil.deskripsi }}
                    </p>
                  </div>
                </div>
              </section>

              <!-- Dokumen & Panduan Akademik Program Studi (Profil Lulusan, Pedoman Akademik, Kurikulum, RPS) -->
              <section class="card rounded-2xl p-6 sm:p-8 lg:p-10 border border-emerald-500/20 shadow-xl" id="dokumen-akademik">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                  <div class="flex items-center gap-3">
                    <span class="w-10 h-10 rounded-xl bg-emerald-500/20 text-emerald-300 flex items-center justify-center text-base shrink-0 border border-emerald-500/30">
                      <i class="fas fa-folder-open"></i>
                    </span>
                    <div>
                      <span class="text-xs font-bold uppercase tracking-wider text-emerald-400 block">Arsip &amp; Panduan</span>
                      <h2 class="text-xl sm:text-2xl font-bold text-white tracking-tight">
                        Dokumen &amp; Panduan Akademik
                      </h2>
                    </div>
                  </div>
                  <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 self-start sm:self-center">
                    <i class="fas fa-check-circle text-[11px]"></i>
                    {{ dokumensList.length }} Dokumen Tersedia
                  </span>
                </div>

                <p class="text-xs sm:text-sm text-slate-300 mb-6 leading-relaxed">
                  Akses dan unduh berkas resmi program studi mencakup dokumen profil kelulusan, buku pedoman akademik, struktur kurikulum, serta Rencana Pembelajaran Semester (RPS).
                </p>

                <!-- Filter Tabs & Quick Search -->
                <div class="space-y-3.5 mb-6">
                  <!-- Category Filter Tabs -->
                  <div class="flex flex-wrap items-center gap-1.5">
                    <button
                      type="button"
                      @click="selectedDokumenKategori = 'semua'"
                      class="px-3.5 py-1.5 rounded-full text-xs font-semibold transition-all duration-200 flex items-center gap-1.5 cursor-pointer"
                      :class="selectedDokumenKategori === 'semua'
                        ? 'bg-[#16a34a] text-white shadow-xs'
                        : 'bg-emerald-950/50 text-slate-300 hover:bg-emerald-900/60 border border-emerald-500/20'"
                    >
                      <span>Semua</span>
                      <span
                        class="px-1.5 py-0.5 rounded-full text-[10px] font-mono leading-none"
                        :class="selectedDokumenKategori === 'semua' ? 'bg-white/20 text-white' : 'bg-emerald-900/80 text-emerald-300'"
                      >
                        {{ dokumensList.length }}
                      </span>
                    </button>

                    <button
                      v-for="kat in availableDokumenKategoris"
                      :key="kat.slug"
                      type="button"
                      @click="selectedDokumenKategori = kat.slug"
                      class="px-3.5 py-1.5 rounded-full text-xs font-semibold transition-all duration-200 flex items-center gap-1.5 cursor-pointer"
                      :class="selectedDokumenKategori === kat.slug
                        ? 'bg-[#16a34a] text-white shadow-xs'
                        : 'bg-emerald-950/50 text-slate-300 hover:bg-emerald-900/60 border border-emerald-500/20'"
                    >
                      <span>{{ kat.ikon || '📌' }}</span>
                      <span>{{ kat.nama }}</span>
                      <span
                        class="px-1.5 py-0.5 rounded-full text-[10px] font-mono leading-none"
                        :class="selectedDokumenKategori === kat.slug ? 'bg-white/20 text-white' : 'bg-emerald-900/80 text-emerald-300'"
                      >
                        {{ getDokumenCountByKategori(kat.slug) }}
                      </span>
                    </button>
                  </div>

                  <!-- Reactive Client Search Input (No refresh) -->
                  <div class="relative">
                    <i class="fas fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-emerald-400/70 text-xs"></i>
                    <input
                      v-model="searchDokumenQuery"
                      type="text"
                      placeholder="Cari nama dokumen, periode tahun, atau kata kunci..."
                      class="w-full pl-9 pr-8 py-2 text-xs sm:text-sm rounded-xl border border-emerald-500/30 focus:outline-hidden focus:border-emerald-400 focus:ring-1 focus:ring-emerald-400 transition-all bg-emerald-950/60 text-white placeholder-slate-400"
                    />
                    <button
                      v-if="searchDokumenQuery"
                      @click="searchDokumenQuery = ''"
                      type="button"
                      class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-white text-xs cursor-pointer"
                      title="Hapus pencarian"
                    >
                      <i class="fas fa-times-circle"></i>
                    </button>
                  </div>
                </div>

                <!-- Document List Cards -->
                <div v-if="filteredDokumens.length > 0" class="space-y-3">
                  <div
                    v-for="dok in filteredDokumens"
                    :key="dok.id"
                    class="p-4 sm:p-5 rounded-xl border border-emerald-500/20 hover:border-emerald-400 hover:shadow-lg bg-black/30 hover:bg-emerald-950/60 transition-all duration-200 flex flex-col sm:flex-row sm:items-center justify-between gap-4 group"
                  >
                    <!-- Left: File Icon & Meta Details -->
                    <div class="flex items-start gap-3.5 min-w-0 flex-1">
                      <!-- File Format Icon -->
                      <div
                        class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0 text-sm font-bold shadow-2xs"
                        :class="isWordFile(dok.file_dokumen)
                          ? 'bg-blue-500/20 text-blue-300 border border-blue-500/30'
                          : 'bg-rose-500/20 text-rose-300 border border-rose-500/30'"
                      >
                        <i :class="isWordFile(dok.file_dokumen) ? 'fas fa-file-word' : 'fas fa-file-pdf'"></i>
                      </div>

                      <div class="min-w-0 flex-1">
                        <!-- Badges Row -->
                        <div class="flex flex-wrap items-center gap-1.5 mb-1">
                          <span
                            class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[11px] font-semibold"
                            :class="getBadgeClass(dok.kategori_model?.warna)"
                          >
                            <span>{{ dok.kategori_model?.ikon || '📌' }}</span>
                            <span>{{ dok.kategori_model?.nama || dok.kategori }}</span>
                          </span>

                          <span v-if="dok.tahun" class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[11px] font-medium bg-emerald-950/80 text-emerald-300 border border-emerald-500/20">
                            <i class="fas fa-calendar-alt text-[10px]"></i>
                            <span>{{ dok.tahun }}</span>
                          </span>

                          <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-mono uppercase bg-emerald-950/80 text-emerald-400 border border-emerald-500/20 font-bold">
                            {{ getFileExt(dok.file_dokumen) }}
                          </span>
                        </div>

                        <!-- Document Title -->
                        <h4 class="text-sm sm:text-base font-bold text-white group-hover:text-emerald-300 transition-colors leading-snug">
                          {{ dok.nama_dokumen }}
                        </h4>

                        <!-- Description if present -->
                        <p v-if="dok.deskripsi" class="text-xs text-slate-300 mt-1 leading-relaxed">
                          {{ dok.deskripsi }}
                        </p>
                      </div>
                    </div>

                    <!-- Right Action Button -->
                    <div class="flex items-center gap-2 shrink-0 self-end sm:self-center">
                      <a
                        :href="`/uploads/program_studi/dokumen/${dok.file_dokumen}`"
                        target="_blank"
                        download
                        class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs font-bold bg-[#16a34a] text-white hover:bg-[#15803d] transition-all shadow-xs group-hover:scale-102"
                      >
                        <i class="fas fa-download text-[11px]"></i>
                        <span>Unduh Berkas</span>
                      </a>
                    </div>
                  </div>
                </div>

                <!-- Empty State -->
                <div v-else class="text-center py-10 px-4 rounded-xl bg-black/25 border border-dashed border-emerald-500/30">
                  <div class="w-12 h-12 rounded-full bg-emerald-500/20 text-emerald-300 flex items-center justify-center mx-auto mb-3 text-lg border border-emerald-500/30">
                    <i class="fas fa-folder-open"></i>
                  </div>
                  <h4 class="text-sm font-bold text-white mb-1">
                    Tidak Ada Dokumen Yang Sesuai
                  </h4>
                  <p class="text-xs text-slate-300 max-w-sm mx-auto mb-3">
                    {{ searchDokumenQuery ? 'Tidak ditemukan dokumen dengan kata kunci tersebut. Coba gunakan kata kunci lain.' : 'Belum ada dokumen yang diunggah untuk kategori ini.' }}
                  </p>
                  <button
                    v-if="selectedDokumenKategori !== 'semua' || searchDokumenQuery"
                    type="button"
                    @click="selectedDokumenKategori = 'semua'; searchDokumenQuery = ''"
                    class="text-xs font-semibold text-emerald-400 hover:underline cursor-pointer"
                  >
                    Reset Filter &amp; Pencarian
                  </button>
                </div>
              </section>

              <!-- 4. Fasilitas Penunjang / Laboratorium -->
              <section v-if="fasilitasList.length > 0" class="card rounded-2xl p-6 sm:p-8 lg:p-10 border border-emerald-500/20 shadow-xl">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
                  <div class="flex items-center gap-3">
                    <span class="w-10 h-10 rounded-xl bg-emerald-500/20 text-emerald-300 flex items-center justify-center text-base shrink-0 border border-emerald-500/30">
                      <i class="fas fa-laptop-code"></i>
                    </span>
                    <div>
                      <span class="text-xs font-bold uppercase tracking-wider text-emerald-400 block">Infrastruktur Perkuliahan</span>
                      <h2 class="text-xl sm:text-2xl font-bold text-white tracking-tight">
                        Fasilitas &amp; Laboratorium
                      </h2>
                    </div>
                  </div>
                  <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 self-start sm:self-center">
                    <i class="fas fa-microchip text-[11px]"></i>
                    {{ fasilitasList.length }} Sarana Praktik
                  </span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                  <div
                    v-for="(fas, idx) in fasilitasList"
                    :key="fas.id || idx"
                    class="p-5 sm:p-6 rounded-xl border border-emerald-500/20 hover:border-emerald-400/50 bg-black/30 hover:bg-emerald-950/60 transition-all duration-300 group hover:shadow-lg"
                  >
                    <div class="w-10 h-10 rounded-lg bg-emerald-500/20 group-hover:bg-[#16a34a] text-emerald-300 group-hover:text-white flex items-center justify-center text-sm font-bold transition-colors mb-4 border border-emerald-500/30">
                      <i :class="getFasilitasIcon(fas.icon, idx)"></i>
                    </div>
                    <h3 class="text-base font-bold text-white group-hover:text-emerald-300 transition-colors mb-2">
                      {{ fas.nama }}
                    </h3>
                    <p class="text-xs sm:text-sm text-slate-300 leading-relaxed">
                      {{ fas.deskripsi }}
                    </p>
                  </div>
                </div>
              </section>

              <!-- 5. Tanya Jawab Program Studi (Interactive Accordion) -->
              <section v-if="faqsList.length > 0" class="card rounded-2xl p-6 sm:p-8 lg:p-10 border border-emerald-500/20 shadow-xl">
                <div class="flex items-center gap-3 mb-8">
                  <span class="w-10 h-10 rounded-xl bg-emerald-500/20 text-emerald-300 flex items-center justify-center text-base shrink-0 border border-emerald-500/30">
                    <i class="fas fa-question-circle"></i>
                  </span>
                  <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-emerald-400 block">Seputar Perkuliahan</span>
                    <h2 class="text-xl sm:text-2xl font-bold text-white tracking-tight">
                      Pertanyaan Umum (FAQ)
                    </h2>
                  </div>
                </div>

                <div class="space-y-3">
                  <div
                    v-for="(faq, idx) in faqsList"
                    :key="faq.id || idx"
                    class="rounded-xl border transition-all duration-200 overflow-hidden"
                    :class="activeFaqIndex === idx ? 'border-emerald-400 bg-emerald-950/60' : 'border-emerald-500/20 bg-black/30 hover:border-emerald-500/40'"
                  >
                    <button
                      type="button"
                      class="w-full px-5 py-4 text-left flex items-center justify-between gap-4 transition-colors select-none"
                      @click="toggleFaq(idx)"
                      :aria-expanded="activeFaqIndex === idx"
                    >
                      <span class="font-bold text-sm sm:text-base text-white flex items-center gap-3">
                        <span class="w-6 h-6 rounded-full bg-emerald-500/20 text-emerald-300 text-xs font-mono font-semibold flex items-center justify-center shrink-0 border border-emerald-500/30">
                          {{ idx + 1 }}
                        </span>
                        {{ faq.pertanyaan }}
                      </span>
                      <i
                        class="fas fa-chevron-down text-xs text-emerald-400 transition-transform duration-300 shrink-0"
                        :class="{ 'rotate-180': activeFaqIndex === idx }"
                      ></i>
                    </button>

                    <div
                      v-show="activeFaqIndex === idx"
                      class="px-5 pb-5 pt-1 text-xs sm:text-sm text-slate-300 leading-relaxed border-t border-emerald-500/20"
                    >
                      <p>{{ faq.jawaban }}</p>
                    </div>
                  </div>
                </div>
              </section>

            </div>

            <!-- RIGHT COLUMN: Sidebar (4 cols) -->
            <aside class="lg:col-span-4 space-y-8 lg:sticky lg:top-28">
              
              <!-- 1. Visual Card / Monogram Showcase -->
              <div class="card rounded-2xl overflow-hidden border border-emerald-500/20 shadow-xl">
                <!-- Thumbnail Image if available and not errored -->
                <div v-if="program.thumbnail && !imageError" class="relative aspect-video sm:aspect-4/3 w-full bg-slate-900 overflow-hidden">
                  <img
                    :src="`/uploads/program_studi/${program.thumbnail}`"
                    :alt="program.nama_prodi"
                    class="w-full h-full object-cover"
                    loading="lazy"
                    @error="handleImageError"
                  />
                  <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                  <div class="absolute bottom-3 left-3 right-3 flex items-center justify-between text-white text-xs font-semibold">
                    <span class="px-2.5 py-1 rounded-md bg-[#052e16]/80 backdrop-blur-xs border border-white/20">
                      {{ program.nama_prodi }}
                    </span>
                    <span class="font-mono text-emerald-300">D3</span>
                  </div>
                </div>

                <!-- Academic Monogram Fallback if no image -->
                <div
                  v-else
                  class="aspect-4/3 w-full p-6 flex flex-col justify-between bg-gradient-to-br from-[#052e16] to-[#14532d] text-white relative overflow-hidden"
                >
                  <div class="absolute inset-0 bg-[linear-gradient(to_right,#ffffff_1px,transparent_1px),linear-gradient(to_bottom,#ffffff_1px,transparent_1px)] bg-[size:2rem_2rem] opacity-5 pointer-events-none"></div>

                  <div class="flex items-center justify-between relative z-10">
                    <span class="text-xs font-mono tracking-widest uppercase text-emerald-300 font-bold">
                      AMIK Taruna
                    </span>
                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-white/10 text-white border border-white/20">
                      Diploma III
                    </span>
                  </div>

                  <div class="my-auto text-center py-4 relative z-10">
                    <span class="font-mono text-5xl font-extrabold tracking-tight text-white/95 block">
                      {{ getProgramCode(program.nama_prodi) }}
                    </span>
                    <span class="text-xs font-medium text-emerald-200 mt-2 block">
                      {{ program.nama_prodi }}
                    </span>
                  </div>

                  <div class="flex items-center justify-between text-[11px] text-emerald-200/80 border-t border-white/10 pt-3 relative z-10 font-medium">
                    <span>Gelar A.Md.</span>
                    <span>3 Tahun</span>
                  </div>
                </div>

                <!-- Academic Identity Details -->
                <div class="p-6">
                  <h3 class="text-sm font-bold uppercase tracking-wider text-emerald-400 mb-4">
                    Informasi Program
                  </h3>
                  <dl class="space-y-3 text-xs sm:text-sm">
                    <div class="flex items-center justify-between py-2 border-b border-emerald-500/20">
                      <dt class="text-slate-400">Jenjang Studi</dt>
                      <dd class="font-bold text-white">Diploma III (D3)</dd>
                    </div>
                    <div class="flex items-center justify-between py-2 border-b border-emerald-500/20">
                      <dt class="text-slate-400">Gelar Kelulusan</dt>
                      <dd class="font-bold text-emerald-300">A.Md.</dd>
                    </div>
                    <div class="flex items-center justify-between py-2 border-b border-emerald-500/20">
                      <dt class="text-slate-400">Status Akreditasi</dt>
                      <dd class="font-bold text-white">{{ program.akreditasi || 'Baik' }}</dd>
                    </div>
                    <div class="flex items-center justify-between py-2 border-b border-emerald-500/20">
                      <dt class="text-slate-400">Masa Studi Normal</dt>
                      <dd class="font-bold text-white">6 Semester (3 Tahun)</dd>
                    </div>
                    <div class="flex items-center justify-between py-2">
                      <dt class="text-slate-400">Status PD-Dikti</dt>
                      <dd class="font-bold text-emerald-400 flex items-center gap-1.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                        Aktif Terdaftar
                      </dd>
                    </div>
                  </dl>
                </div>
              </div>

              <!-- 2. Unduhan Dokumen Akademik -->
              <div class="card rounded-2xl p-6 border border-emerald-500/20 shadow-xl">
                <div class="flex items-center gap-2.5 mb-4">
                  <i class="fas fa-file-pdf text-emerald-400"></i>
                  <h3 class="text-base font-bold text-white">
                    Dokumen &amp; Unduhan
                  </h3>
                </div>

                <div v-if="dokumensList.length > 0 || program.kalender_akademik || program.jadwal_semester" class="space-y-3">
                  <!-- Kalender Akademik Download -->
                  <a
                    v-if="program.kalender_akademik"
                    :href="`/uploads/program_studi/${program.kalender_akademik}`"
                    target="_blank"
                    download
                    class="group flex items-center justify-between p-3.5 rounded-xl border border-emerald-500/20 hover:border-emerald-400 hover:bg-emerald-950/60 transition-colors"
                  >
                    <div class="flex items-center gap-3">
                      <span class="w-8 h-8 rounded-lg bg-emerald-500/20 text-emerald-300 flex items-center justify-center text-xs font-bold border border-emerald-500/30">
                        <i class="fas fa-calendar-alt"></i>
                      </span>
                      <div>
                        <span class="text-xs font-bold text-white block group-hover:text-emerald-300">Kalender Akademik</span>
                        <span class="text-[11px] text-slate-400">Format PDF Resmi</span>
                      </div>
                    </div>
                    <i class="fas fa-download text-xs text-slate-400 group-hover:text-emerald-300 transition-colors"></i>
                  </a>

                  <!-- Jadwal Semester Download -->
                  <a
                    v-if="program.jadwal_semester"
                    :href="`/uploads/program_studi/${program.jadwal_semester}`"
                    target="_blank"
                    download
                    class="group flex items-center justify-between p-3.5 rounded-xl border border-emerald-500/20 hover:border-emerald-400 hover:bg-emerald-950/60 transition-colors"
                  >
                    <div class="flex items-center gap-3">
                      <span class="w-8 h-8 rounded-lg bg-emerald-500/20 text-emerald-300 flex items-center justify-center text-xs font-bold border border-emerald-500/30">
                        <i class="fas fa-clock"></i>
                      </span>
                      <div>
                        <span class="text-xs font-bold text-white block group-hover:text-emerald-300">Jadwal Perkuliahan</span>
                        <span class="text-[11px] text-slate-400">Format PDF Resmi</span>
                      </div>
                    </div>
                    <i class="fas fa-download text-xs text-slate-400 group-hover:text-emerald-300 transition-colors"></i>
                  </a>

                  <!-- List of Quick Prodi Documents -->
                  <div v-if="dokumensList.length > 0" class="pt-2 border-t border-emerald-500/20">
                    <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2">
                      Dokumen Prodi ({{ dokumensList.length }})
                    </div>
                    <div class="space-y-2">
                      <a
                        v-for="d in dokumensList.slice(0, 3)"
                        :key="d.id"
                        :href="`/uploads/program_studi/dokumen/${d.file_dokumen}`"
                        target="_blank"
                        download
                        class="group flex items-center justify-between p-2.5 rounded-lg border border-emerald-500/20 hover:border-emerald-400 hover:bg-emerald-950/60 transition-colors"
                      >
                        <div class="flex items-center gap-2.5 min-w-0">
                          <i :class="isWordFile(d.file_dokumen) ? 'fas fa-file-word text-blue-400 text-xs' : 'fas fa-file-pdf text-rose-400 text-xs'"></i>
                          <div class="min-w-0">
                            <span class="text-xs font-semibold text-white block truncate group-hover:text-emerald-300">
                              {{ d.nama_dokumen }}
                            </span>
                            <span class="text-[10px] text-slate-400 block truncate">
                              {{ d.kategori_model?.nama || d.kategori }}
                            </span>
                          </div>
                        </div>
                        <i class="fas fa-download text-[10px] text-slate-400 group-hover:text-emerald-300 shrink-0 ml-2"></i>
                      </a>
                    </div>
                    <a href="#dokumen-akademik" class="text-xs text-emerald-400 font-semibold hover:underline block text-center pt-2">
                      Jelajahi Seluruh Dokumen &rarr;
                    </a>
                  </div>
                </div>

                <div v-else class="text-xs text-slate-300 leading-relaxed p-3.5 rounded-xl bg-emerald-950/40 border border-emerald-500/20">
                  <p class="mb-2">Dokumen kalender, silabus, dan pedoman akademik dapat diakses secara langsung melalui sistem informasi BAAK kampus.</p>
                  <a :href="whatsappUrl" target="_blank" class="font-semibold text-emerald-300 hover:underline flex items-center gap-1">
                    <i class="fab fa-whatsapp"></i>
                    <span>Tanya BAAK via WhatsApp</span>
                  </a>
                </div>
              </div>

              <!-- 3. Hubungi Konsultasi & PMB Card -->
              <div class="card bg-gradient-to-br from-[#052e16] to-[#14532d] text-white rounded-2xl p-6 relative overflow-hidden shadow-xl border border-emerald-500/25">
                <div class="absolute inset-0 bg-[linear-gradient(to_right,#ffffff_1px,transparent_1px),linear-gradient(to_bottom,#ffffff_1px,transparent_1px)] bg-[size:2rem_2rem] opacity-5 pointer-events-none"></div>

                <div class="relative z-10">
                  <span class="text-[10px] font-mono uppercase tracking-widest text-emerald-300 font-bold bg-white/10 px-2.5 py-1 rounded-full inline-block mb-3 border border-white/15">
                    Penerimaan Mahasiswa Baru
                  </span>
                  <h3 class="text-lg font-bold text-white tracking-tight mb-2">
                    Siap Memulai Karier IT Anda?
                  </h3>
                  <p class="text-xs text-emerald-100/80 leading-relaxed mb-6">
                    Daftar sekarang di {{ program.nama_prodi }} atau konsultasikan minat keahlian Anda bersama tim admisi kami.
                  </p>

                  <div class="space-y-2.5">
                    <a
                      href="/pmb"
                      class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-white text-[#14532d] text-xs font-bold hover:bg-[#dcfce7] transition-colors shadow-xs"
                    >
                      <i class="fas fa-user-plus text-[11px]"></i>
                      <span>Daftar Online (PMB)</span>
                    </a>
                    <a
                      :href="whatsappUrl"
                      target="_blank"
                      rel="noopener noreferrer"
                      class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-[#16a34a] text-white text-xs font-bold hover:bg-[#15803d] border border-emerald-500/40 transition-colors"
                    >
                      <i class="fab fa-whatsapp text-sm text-emerald-300"></i>
                      <span>Konsultasi Jurusan</span>
                    </a>
                  </div>
                </div>
              </div>

              <!-- 4. Kembali ke Katalog Akademik -->
              <div class="text-center pt-2">
                <a
                  href="/akademik"
                  class="inline-flex items-center gap-2 text-xs font-bold text-[#166534] hover:text-[#14532d] p-2 hover:bg-emerald-50 rounded-lg transition-colors"
                >
                  <i class="fas fa-arrow-left text-[11px]"></i>
                  <span>Lihat Seluruh Program Studi</span>
                </a>
              </div>

            </aside>

          </div>
        </div>
      </section>

      <!-- 4. Institutional Call to Action (PMB & WhatsApp Konsultasi) -->
      <CtaSection :setting="setting" />
    </main>

    <!-- 5. Footer (Calm, High Contrast Slate, Verified Links) -->
    <AppFooter :setting="setting" />

  </div>
</template>
