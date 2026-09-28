<script setup>
import { computed } from 'vue';

const props = defineProps({
  dosen: {
    type: Array,
    default: () => []
  },
  setting: {
    type: Object,
    default: () => ({})
  }
});

const eyebrow = computed(() => props.setting?.page_headers?.home_dosen?.eyebrow || 'Kepemimpinan & Pengajar');
const title = computed(() => props.setting?.page_headers?.home_dosen?.title || 'Sivitas pengajar berdedikasi');
const titleHighlight = computed(() => props.setting?.page_headers?.home_dosen?.highlight || 'mengawal mutu akademik.');
const subtitle = computed(() => props.setting?.page_headers?.home_dosen?.subtitle || 'Dipimpin oleh para akademisi dan praktisi berpengalaman yang berfokus pada kemajuan kompetensi mahasiswa di bidang teknologi informasi terapan.');

// Select top 4 leadership figures: Direktur & 3 Wakil Direktur
const leadershipFigures = computed(() => {
  if (!props.dosen || props.dosen.length === 0) return [];

  // 1. If explicit IDs are set in admin settings (e.g. [6, 10, 12, 13])
  let configuredIds = props.setting?.home_dosen_ids;
  if (typeof configuredIds === 'string') {
    try {
      configuredIds = JSON.parse(configuredIds);
    } catch (e) {
      configuredIds = null;
    }
  }

  if (Array.isArray(configuredIds) && configuredIds.length > 0) {
    const list = [];
    for (const id of configuredIds) {
      const found = props.dosen.find(d => Number(d.id) === Number(id));
      if (found) list.push(found);
    }
    if (list.length > 0) return list.slice(0, 4);
  }

  // 2. Fallback: strictly filter for Direktur & Wakil Direktur
  const leaders = props.dosen.filter(d => {
    const lvl = Number(d.level_organigram);
    const jab = (d.jabatan || '').toLowerCase();
    return lvl === 1 || lvl === 2 || jab.includes('direktur');
  });

  if (leaders.length > 0) {
    const sorted = [...leaders].sort((a, b) => {
      const lvlA = Number(a.level_organigram) || 99;
      const lvlB = Number(b.level_organigram) || 99;
      if (lvlA !== lvlB) return lvlA - lvlB;

      // Same level (e.g. both Wadir level 2): sort by Roman Numeral I, II, III
      const getWadirOrder = (jabatan) => {
        const j = (jabatan || '').toLowerCase();
        if (/wadir\s*i\b|wakil\s+direktur\s+i\b|akademik/i.test(j)) return 1;
        if (/wadir\s*ii\b|wakil\s+direktur\s+ii\b|keuangan|administrasi/i.test(j)) return 2;
        if (/wadir\s*iii\b|wakil\s+direktur\s+iii\b|kemahasiswaan|alumni/i.test(j)) return 3;
        return 4;
      };
      return getWadirOrder(a.jabatan) - getWadirOrder(b.jabatan);
    });

    return sorted.slice(0, 4);
  }

  // 3. Fallback: by level_organigram
  const fallbackSorted = [...props.dosen].sort((a, b) => {
    const lvlA = Number(a.level_organigram) || 99;
    const lvlB = Number(b.level_organigram) || 99;
    return lvlA - lvlB;
  });

  return fallbackSorted.slice(0, 4);
});

// Helper for clean primary title (clean multiple pipe strings if any)
const formatJabatan = (jabatanStr) => {
  if (!jabatanStr) return 'Tenaga Pendidik';
  const parts = jabatanStr.split('|');
  return parts[0].trim();
};
</script>

<template>
  <section class="py-16 lg:py-24 border-b border-emerald-900/30">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      
      <!-- Section Header Card -->
      <div class="flex flex-col md:flex-row md:items-end justify-between mb-10 gap-6 bg-white rounded-3xl p-6 sm:p-10 shadow-xl border border-slate-200/80 relative z-10">
        <div class="max-w-2xl">
          <span class="text-xs font-bold uppercase tracking-widest text-brand-800 bg-brand-50 px-3 py-1 rounded border border-brand-200/70">
            {{ eyebrow }}
          </span>
          <h2 class="mt-4 text-3xl sm:text-4xl lg:text-[40px] font-extrabold text-slate-900 tracking-tight leading-[1.18]">
            {{ title }}
            <span v-if="titleHighlight" class="text-brand-800 block">{{ titleHighlight }}</span>
          </h2>
          <p class="mt-4 text-base text-slate-600 leading-relaxed">
            {{ subtitle }}
          </p>
        </div>

        <a
          href="/tentang#struktur"
          class="inline-flex items-center gap-2 text-sm font-bold text-brand-800 hover:text-brand-900 shrink-0 group self-start md:self-auto bg-brand-50 px-4 py-2.5 rounded-xl border border-brand-200/70"
        >
          <span>Struktur Akademik Lengkap</span>
          <span class="text-brand-600 group-hover:translate-x-1.5 transition-transform duration-200">→</span>
        </a>
      </div>

      <!-- Portrait Editorial Grid (No Clunky Shadowed Cards) -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-8">
        <div
          v-for="person in leadershipFigures"
          :key="person.id"
          class="flex flex-col group"
        >
          <!-- Portrait Frame: Clean, Consistent Aspect Ratio, Subtle Zoom -->
          <div class="relative rounded-xl overflow-hidden bg-slate-100 border border-slate-200/80 aspect-[3/4] shadow-sm">
            <img
              :src="person.foto ? '/uploads/' + person.foto : 'https://ui-avatars.com/api/?name=' + encodeURIComponent(person.nama) + '&background=0a2e1e&color=ffffff&size=512'"
              :alt="person.nama"
              class="w-full h-full object-cover object-top group-hover:scale-[1.03] transition-transform duration-700 ease-out"
              loading="lazy"
            />
            <!-- Subtle bottom vignette for ground contrast -->
            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/40 via-transparent to-transparent pointer-events-none"></div>
          </div>

          <!-- Editorial Name & Position (Clear, Large, High Contrast) -->
          <div class="mt-4 flex flex-col">
            <span class="text-xs font-bold text-brand-700 uppercase tracking-wider">
              {{ formatJabatan(person.jabatan) }}
            </span>
            <h3 class="mt-1 text-base sm:text-lg font-bold text-slate-900 group-hover:text-brand-800 transition-colors leading-snug">
              {{ person.nama }}
            </h3>
            <p v-if="person.bidang_keahlian" class="mt-1 text-xs text-slate-500 line-clamp-1">
              {{ person.bidang_keahlian }}
            </p>
          </div>
        </div>
      </div>

    </div>
  </section>
</template>
