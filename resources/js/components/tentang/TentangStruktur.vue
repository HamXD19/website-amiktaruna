<script setup>
import { ref, computed } from 'vue';

const props = defineProps({
  dosen: {
    type: Array,
    default: () => []
  }
});

// View mode: 'organigram' (Struktur Menurun / Hirarki) or 'daftar' (Katalog Dosen)
const viewMode = ref('organigram');
const activeTab = ref('all');

// Helper to format pipe-separated multi-roles
const formatJabatan = (jabatanStr) => {
  if (!jabatanStr) return ['Tenaga Pendidik'];
  const parts = jabatanStr.split('|');
  return parts.map(p => p.trim()).filter(Boolean);
};

// Classification helpers
const isDirektur = (d) => {
  const j = d.jabatan || '';
  return j.includes('Direktur AMIK Taruna') && !j.includes('Wakil Direktur');
};

const isWadir = (d) => {
  const j = d.jabatan || '';
  return j.includes('Wakil Direktur');
};

const isKaprodiOrUnit = (d) => {
  const j = d.jabatan || '';
  if (isDirektur(d) || isWadir(d)) return false;
  return (
    j.includes('Ketua Lembaga') ||
    j.includes('Ketua Pusat') ||
    j.includes('Ketua UPT') ||
    j.includes('Ketua Unit') ||
    j.includes('Ketua Program Studi')
  );
};

const isKabag = (d) => {
  const j = d.jabatan || '';
  if (isDirektur(d) || isWadir(d) || isKaprodiOrUnit(d)) return false;
  return j.includes('Kepala Bagian');
};

const isStaf = (d) => {
  const j = d.jabatan || '';
  if (isDirektur(d) || isWadir(d) || isKaprodiOrUnit(d) || isKabag(d)) return false;
  return j.includes('Staf') || j.includes('Staff');
};

const isDosenPengajar = (d) => {
  const j = d.jabatan || '';
  if (isDirektur(d) || isWadir(d) || isKaprodiOrUnit(d) || isKabag(d) || isStaf(d)) return false;
  return true;
};

// Organigram Levels (Top-down structure)
const organigramLevels = computed(() => {
  // 1. Direktur
  const direktur = props.dosen.filter(isDirektur);

  // 2. Wakil Direktur
  const wadir = props.dosen.filter(isWadir).sort((a, b) => {
    // Sort Wadir I, II, III
    return (a.jabatan || '').localeCompare(b.jabatan || '');
  });

  // 3. Lembaga, Pusat, & Kaprodi
  const kaprodiUnit = props.dosen.filter(isKaprodiOrUnit).sort((a, b) => {
    // Put Ketua Lembaga / Penjaminan mutu first, then Kaprodi
    const getWeight = (j) => {
      if (j.includes('Lembaga')) return 1;
      if (j.includes('Penjaminan')) return 2;
      if (j.includes('Sistem Informasi') && !j.includes('Akuntansi')) return 3;
      if (j.includes('Teknologi Informasi')) return 4;
      if (j.includes('Sistem Informasi Akuntansi')) return 5;
      return 6;
    };
    return getWeight(a.jabatan || '') - getWeight(b.jabatan || '');
  });

  // 4. Kepala Bagian (Kabag)
  const kabag = props.dosen.filter(isKabag);

  // 5. Staf & Tenaga Kependidikan
  const staf = props.dosen.filter(isStaf);

  // 6. Dosen Pengajar Lainnya
  const dosenLain = props.dosen.filter(isDosenPengajar);

  return [
    {
      level: 1,
      title: 'Pimpinan Utama',
      subtitle: 'Direktur AMIK Taruna Probolinggo',
      badge: 'Level 1',
      items: direktur
    },
    {
      level: 2,
      title: 'Pimpinan Pembantu',
      subtitle: 'Wakil Direktur Bidang Akademik, Keuangan & Kemahasiswaan',
      badge: 'Level 2',
      items: wadir
    },
    {
      level: 3,
      title: 'Lembaga, Pusat & Ketua Program Studi',
      subtitle: 'Pelaksana Akademik, Penjaminan Mutu, LPPM & Kaprodi',
      badge: 'Level 3',
      items: kaprodiUnit
    },
    {
      level: 4,
      title: 'Kepala Bagian (Kabag)',
      subtitle: 'Pelaksana Teknis Administrasi Akademik & Umum',
      badge: 'Level 4',
      items: kabag
    },
    {
      level: 5,
      title: 'Staf Administrasi & Layanan',
      subtitle: 'Tenaga Kependidikan, Layanan Informasi & Perpustakaan',
      badge: 'Level 5',
      items: staf
    },
    {
      level: 6,
      title: 'Dosen Pengajar',
      subtitle: 'Tenaga Pendidik Sivitas Akademika AMIK Taruna',
      badge: 'Level 6',
      items: dosenLain
    }
  ].filter(lvl => lvl.items.length > 0);
});

// Helper for initials
const getInitials = (nama) => {
  if (!nama) return 'AT';
  const clean = nama.replace(/(Ir\.|Dr\.|Drs\.|Prof\.|M\.Kom\.|S\.E\.|S\.Kom\.|S\.Si\.|M\.T\.|MBA\.|M\.Pd|S\.Pd\.|M\.Akun\.|M\.ST\.|A\.Md\.Kom\.|S\.S\.)/gi, '').trim();
  return clean.split(' ').filter(Boolean).map(w => w[0]).slice(0, 2).join('').toUpperCase();
};

// Filtered list for "Daftar" view
const filteredList = computed(() => {
  if (activeTab.value === 'all') return props.dosen;
  if (activeTab.value === 'pimpinan') return props.dosen.filter(d => isDirektur(d) || isWadir(d));
  if (activeTab.value === 'kaprodi') return props.dosen.filter(isKaprodiOrUnit);
  if (activeTab.value === 'kabag') return props.dosen.filter(isKabag);
  if (activeTab.value === 'dosen') return props.dosen.filter(isDosenPengajar);
  if (activeTab.value === 'staf') return props.dosen.filter(isStaf);
  return props.dosen;
});

// Count helpers for tabs in catalog view
const counts = computed(() => ({
  all: props.dosen.length,
  pimpinan: props.dosen.filter(d => isDirektur(d) || isWadir(d)).length,
  kaprodi: props.dosen.filter(isKaprodiOrUnit).length,
  kabag: props.dosen.filter(isKabag).length,
  dosen: props.dosen.filter(isDosenPengajar).length,
  staf: props.dosen.filter(isStaf).length
}));
</script>

<template>
  <section id="struktur" class="py-20 lg:py-28 border-b border-emerald-900/30 scroll-mt-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      
      <!-- Section Header Card -->
      <div class="card rounded-3xl p-6 sm:p-10 mb-12 flex flex-col md:flex-row md:items-end justify-between gap-6 relative z-10">
        <div class="max-w-2xl">
          <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
            Sivitas Akademika
          </span>
          <h2 class="mt-4 text-3xl sm:text-4xl lg:text-[40px] font-extrabold text-white tracking-tight leading-[1.18]">
            Struktur Organisasi &amp; Pimpinan
          </h2>
          <p class="mt-4 text-base text-slate-300 leading-relaxed">
            Bagan tata kelola institusi AMIK Taruna Probolinggo yang terstruktur secara hierarkis, dipimpin oleh para akademisi dan praktisi berpengalaman.
          </p>
        </div>

        <!-- View Switcher (Bagan Menurun vs Katalog) -->
        <div class="flex items-center p-1.5 bg-emerald-950/80 rounded-2xl border border-emerald-500/30 self-start md:self-auto shrink-0 shadow-lg">
          <button
            type="button"
            @click="viewMode = 'organigram'"
            class="flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold transition-all"
            :class="viewMode === 'organigram' ? 'bg-emerald-600 text-white shadow-md' : 'text-slate-300 hover:text-white hover:bg-white/5'"
          >
            <i class="fas fa-sitemap text-sm"></i>
            <span>Bagan Struktur</span>
          </button>
          <button
            type="button"
            @click="viewMode = 'daftar'"
            class="flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold transition-all"
            :class="viewMode === 'daftar' ? 'bg-emerald-600 text-white shadow-md' : 'text-slate-300 hover:text-white hover:bg-white/5'"
          >
            <i class="fas fa-th-large text-sm"></i>
            <span>Katalog Sivitas ({{ props.dosen.length }})</span>
          </button>
        </div>
      </div>

      <!-- ============================================================ -->
      <!-- VIEW 1: ORGANIGRAM / STRUKTUR MENURUN (HIERARCHICAL TREE)   -->
      <!-- ============================================================ -->
      <div v-if="viewMode === 'organigram'" class="space-y-12">
        
        <div
          v-for="(levelGroup, lvlIdx) in organigramLevels"
          :key="levelGroup.level"
          class="relative flex flex-col items-center"
        >
          <!-- Level Header Badge -->
          <div class="text-center mb-6 relative z-10">
            <span class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-emerald-950/80 text-emerald-300 border border-emerald-500/40 shadow-sm backdrop-blur-sm">
              <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
              {{ levelGroup.title }}
            </span>
            <p class="text-xs text-slate-400 mt-1.5 font-medium">{{ levelGroup.subtitle }}</p>
          </div>

          <!-- Cards Row Container (Tiered flow) -->
          <div
            class="w-full flex flex-wrap justify-center items-stretch gap-6 sm:gap-7 relative z-10"
            :class="[
              levelGroup.items.length === 1 ? 'max-w-md mx-auto' :
              levelGroup.items.length === 2 ? 'max-w-2xl mx-auto' :
              levelGroup.items.length === 3 ? 'max-w-4xl mx-auto' : 'max-w-6xl mx-auto'
            ]"
          >
            <!-- Member Card (Styled exactly like reference organigram) -->
            <a
              v-for="person in levelGroup.items"
              :key="person.id"
              :href="'/dosen/' + person.id"
              class="card group relative flex flex-col items-center text-center p-5 rounded-2xl transition-all duration-300 hover:-translate-y-1.5 hover:shadow-2xl hover:border-emerald-400/60"
              :class="[
                levelGroup.level === 1 ? 'w-full sm:w-80 border-emerald-400/50 ring-1 ring-emerald-400/30' :
                levelGroup.level === 2 ? 'w-full sm:w-72 border-emerald-500/30' :
                'w-full sm:w-64 border-emerald-500/20'
              ]"
            >
              <!-- Avatar Circle with Emerald Glow & Ring -->
              <div class="relative mb-3.5">
                <div class="relative w-24 h-24 sm:w-28 sm:h-28 rounded-full overflow-hidden bg-slate-900 ring-2 ring-emerald-400/50 shadow-lg group-hover:ring-emerald-300 transition-all">
                  <img
                    v-if="person.foto"
                    :src="'/uploads/' + person.foto"
                    :alt="person.nama"
                    class="w-full h-full object-cover object-top group-hover:scale-105 transition-transform duration-500"
                    loading="lazy"
                  />
                  <!-- Elegant Fallback Avatar -->
                  <div
                    v-else
                    class="w-full h-full flex flex-col items-center justify-center bg-gradient-to-br from-[#052e16] to-[#14532d] text-white p-2"
                  >
                    <span class="font-mono font-bold text-xl sm:text-2xl text-emerald-200">
                      {{ getInitials(person.nama) }}
                    </span>
                  </div>
                </div>

                <!-- Small ID / Role icon badge -->
                <span
                  v-if="levelGroup.level === 1"
                  class="absolute -bottom-1 -right-1 w-7 h-7 rounded-full bg-emerald-500 text-slate-950 flex items-center justify-center text-xs shadow-md"
                  title="Direktur Institusi"
                >
                  <i class="fas fa-crown"></i>
                </span>
                <span
                  v-else-if="levelGroup.level === 2"
                  class="absolute -bottom-1 -right-1 w-6 h-6 rounded-full bg-emerald-600 text-white flex items-center justify-center text-[10px] shadow-md border border-emerald-300/40"
                  title="Wakil Direktur"
                >
                  <i class="fas fa-award"></i>
                </span>
              </div>

              <!-- Person Name -->
              <h3
                class="font-bold text-white group-hover:text-emerald-300 transition-colors leading-snug line-clamp-2"
                :class="levelGroup.level === 1 ? 'text-base sm:text-lg font-extrabold' : 'text-sm sm:text-base'"
              >
                {{ person.nama }}
              </h3>

              <!-- Role / Position Pill (Green Pill underneath name matching screenshot) -->
              <div class="mt-2.5 flex flex-col items-center gap-1 w-full">
                <span
                  v-for="(jbt, jIdx) in formatJabatan(person.jabatan)"
                  :key="jIdx"
                  class="inline-block px-3 py-1 rounded-full text-[11px] font-semibold text-center border max-w-full truncate"
                  :class="[
                    jIdx === 0
                      ? 'bg-emerald-500/20 text-emerald-300 border-emerald-500/40 shadow-xs'
                      : 'bg-slate-900/80 text-slate-300 border-slate-700/50 text-[10px]'
                  ]"
                  :title="jbt"
                >
                  {{ jbt }}
                </span>
              </div>

              <!-- Profile Arrow -->
              <div class="mt-4 pt-3 w-full border-t border-emerald-500/15 flex items-center justify-center gap-1.5 text-xs text-slate-400 group-hover:text-emerald-300 font-medium transition-colors">
                <span>Lihat Profil</span>
                <span class="group-hover:translate-x-1 transition-transform">→</span>
              </div>
            </a>
          </div>

          <!-- Vertical Connector Line linking to the next level below ("menurun") -->
          <div
            v-if="lvlIdx < organigramLevels.length - 1"
            class="flex flex-col items-center my-6"
          >
            <div class="w-0.5 h-8 bg-gradient-to-b from-emerald-500/60 to-emerald-500/20"></div>
            <div class="w-2.5 h-2.5 rounded-full border-2 border-emerald-400 bg-emerald-950"></div>
            <div class="w-0.5 h-4 bg-gradient-to-b from-emerald-500/20 to-transparent"></div>
          </div>
        </div>

      </div>

      <!-- ============================================================ -->
      <!-- VIEW 2: KATALOG / GRID SIVITAS DENGAN TAB FILTER            -->
      <!-- ============================================================ -->
      <div v-else>
        <!-- Filter Tabs -->
        <div class="flex flex-wrap items-center gap-1.5 mb-8 p-1.5 bg-emerald-950/80 rounded-2xl border border-emerald-500/30">
          <button
            type="button"
            @click="activeTab = 'all'"
            class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all"
            :class="activeTab === 'all' ? 'bg-emerald-600 text-white shadow-xs' : 'text-slate-300 hover:text-white hover:bg-white/10'"
          >
            Semua ({{ counts.all }})
          </button>
          <button
            type="button"
            @click="activeTab = 'pimpinan'"
            class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all"
            :class="activeTab === 'pimpinan' ? 'bg-emerald-600 text-white shadow-xs' : 'text-slate-300 hover:text-white hover:bg-white/10'"
          >
            Pimpinan ({{ counts.pimpinan }})
          </button>
          <button
            type="button"
            @click="activeTab = 'kaprodi'"
            class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all"
            :class="activeTab === 'kaprodi' ? 'bg-emerald-600 text-white shadow-xs' : 'text-slate-300 hover:text-white hover:bg-white/10'"
          >
            Lembaga &amp; Kaprodi ({{ counts.kaprodi }})
          </button>
          <button
            type="button"
            @click="activeTab = 'kabag'"
            class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all"
            :class="activeTab === 'kabag' ? 'bg-emerald-600 text-white shadow-xs' : 'text-slate-300 hover:text-white hover:bg-white/10'"
          >
            Kepala Bagian ({{ counts.kabag }})
          </button>
          <button
            type="button"
            @click="activeTab = 'dosen'"
            class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all"
            :class="activeTab === 'dosen' ? 'bg-emerald-600 text-white shadow-xs' : 'text-slate-300 hover:text-white hover:bg-white/10'"
          >
            Dosen Pengajar ({{ counts.dosen }})
          </button>
          <button
            type="button"
            @click="activeTab = 'staf'"
            class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all"
            :class="activeTab === 'staf' ? 'bg-emerald-600 text-white shadow-xs' : 'text-slate-300 hover:text-white hover:bg-white/10'"
          >
            Staf Administrasi ({{ counts.staf }})
          </button>
        </div>

        <!-- Empty State -->
        <div
          v-if="filteredList.length === 0"
          class="card rounded-3xl p-16 text-center text-slate-300"
        >
          <p class="font-medium text-white">Data civitas akademika tidak ditemukan pada kategori ini.</p>
        </div>

        <!-- Portrait Grid -->
        <div v-else class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 lg:gap-8">
          <a
            v-for="person in filteredList"
            :key="person.id"
            :href="'/dosen/' + person.id"
            class="card rounded-2xl p-3.5 flex flex-col group transition-all duration-300 hover:-translate-y-1"
          >
            <!-- Portrait Container -->
            <div class="relative rounded-xl overflow-hidden bg-slate-900/80 aspect-[3/4] w-full border border-emerald-500/20">
              <img
                v-if="person.foto"
                :src="'/uploads/' + person.foto"
                :alt="person.nama"
                class="w-full h-full object-cover object-top group-hover:scale-[1.03] transition-transform duration-700 ease-out"
                loading="lazy"
              />
              
              <!-- Fallback Avatar -->
              <div
                v-else
                class="w-full h-full flex flex-col items-center justify-center bg-gradient-to-br from-[#052e16] to-[#14532d] text-white p-4 text-center"
              >
                <div class="w-16 h-16 rounded-full bg-white/10 border border-white/20 flex items-center justify-center mb-2 font-mono font-bold text-xl text-[#dcfce7]">
                  {{ getInitials(person.nama) }}
                </div>
                <span class="text-[11px] uppercase tracking-wider text-emerald-200 font-medium">AMIK Taruna</span>
              </div>

              <!-- Top Badge -->
              <div class="absolute top-2.5 left-2.5 right-2.5 flex justify-between items-start pointer-events-none">
                <span
                  v-if="isDirektur(person)"
                  class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-emerald-950/90 text-emerald-300 backdrop-blur-xs border border-emerald-500/30"
                >
                  Direktur
                </span>
                <span
                  v-else-if="isWadir(person)"
                  class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-emerald-950/90 text-emerald-300 backdrop-blur-xs border border-emerald-500/30"
                >
                  Wadir
                </span>
                <span
                  v-else-if="isKaprodiOrUnit(person)"
                  class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-emerald-900/90 text-white backdrop-blur-xs border border-emerald-500/30"
                >
                  Kaprodi / Unit
                </span>
              </div>

              <!-- Bottom Vignette -->
              <div class="absolute inset-0 bg-gradient-to-t from-slate-950/60 via-transparent to-transparent pointer-events-none"></div>
            </div>

            <!-- Name & Position Info -->
            <div class="mt-4 px-1 pb-1 flex flex-col flex-1 justify-between">
              <div>
                <span class="text-[11px] font-bold text-emerald-400 uppercase tracking-wider block mb-1 line-clamp-1">
                  {{ formatJabatan(person.jabatan)[0] }}
                </span>
                <h3 class="text-sm sm:text-base font-bold text-white group-hover:text-emerald-300 transition-colors leading-snug">
                  {{ person.nama }}
                </h3>
                <p
                  v-if="formatJabatan(person.jabatan).length > 1"
                  class="text-xs text-slate-300 mt-1 line-clamp-1 font-normal"
                >
                  {{ formatJabatan(person.jabatan).slice(1).join(' • ') }}
                </p>
              </div>

              <div class="mt-4 pt-2.5 border-t border-emerald-500/20 flex items-center justify-between text-xs text-slate-400 group-hover:text-emerald-300 font-medium transition-colors">
                <span>Lihat profil &amp; NIDN</span>
                <span class="text-slate-400 group-hover:translate-x-1 group-hover:text-emerald-300 transition-all">→</span>
              </div>
            </div>
          </a>
        </div>
      </div>

      <!-- Institutional Verification Note -->
      <div class="mt-14 pt-8 border-t border-emerald-900/30 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-400">
        <div class="flex items-center gap-2">
          <i class="fas fa-check-circle text-emerald-400"></i>
          <span>Seluruh data pengajar dan struktural terdaftar resmi pada sistem kepegawaian institusi AMIK Taruna Probolinggo.</span>
        </div>
        <span class="font-mono text-emerald-300 font-medium">Total: {{ props.dosen.length }} Sivitas Akademika</span>
      </div>

    </div>
  </section>
</template>

