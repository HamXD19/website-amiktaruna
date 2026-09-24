<script setup>
import { ref } from 'vue';

const props = defineProps({
  programStudis: {
    type: Array,
    default: () => []
  }
});

const activeHoverIndex = ref(0);

// Default programs fallback if array is empty
const defaultPrograms = [
  {
    id: 1,
    nama_prodi: 'Sistem Informasi',
    slug: 'sistem-informasi',
    akreditasi: 'Baik',
    deskripsi: 'Memadukan keahlian analitis bisnis, rekayasa proses, dan implementasi perangkat lunak sistem informasi untuk kebutuhan korporasi maupun instansi modern.',
    jenjang: 'Diploma 3 (D3)'
  },
  {
    id: 2,
    nama_prodi: 'Teknologi Informasi',
    slug: 'teknologi-informasi',
    akreditasi: 'Baik',
    deskripsi: 'Fokus pada penguasaan infrastruktur jaringan komputer, komputasi awan (cloud), pemeliharaan sistem, dan pengembangan aplikasi digital berbasis web/mobile.',
    jenjang: 'Diploma 3 (D3)'
  },
  {
    id: 3,
    nama_prodi: 'Sistem Informasi Akuntansi',
    slug: 'sistem-informasi-akuntansi',
    akreditasi: 'Baik',
    deskripsi: 'Mengintegrasikan keilmuan akuntansi dan audit keuangan dengan otomasi sistem komputasi guna menghasilkan tenaga ahli keuangan digital yang andal.',
    jenjang: 'Diploma 3 (D3)'
  }
];

const displayPrograms = computed(() => {
  if (props.programStudis && props.programStudis.length > 0) {
    return props.programStudis;
  }
  return defaultPrograms;
});

// Helper for clean description
const getProdiExcerpt = (p) => {
  if (p.deskripsi && p.deskripsi.length > 15 && !p.deskripsi.startsWith('JBHK')) {
    return p.deskripsi;
  }
  // Fallback to meaningful description according to major name
  const match = defaultPrograms.find(dp => dp.nama_prodi.toLowerCase() === p.nama_prodi.toLowerCase());
  return match ? match.deskripsi : 'Program studi vokasi berorientasi keahlian terapan dan kesiapan kerja di sektor industri teknologi informasi modern.';
};
</script>

<script>
import { computed } from 'vue';
export default {
  inheritAttrs: false
};
</script>

<template>
  <section class="py-16 lg:py-24 border-b border-emerald-900/30">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      
      <!-- Section Header: Editorial & Prestigious Card -->
      <div class="max-w-3xl mb-10 bg-white rounded-3xl p-6 sm:p-10 shadow-xl border border-slate-200/80 relative z-10">
        <span class="text-xs font-bold uppercase tracking-widest text-brand-800 bg-brand-50 px-3 py-1 rounded border border-brand-200/70">
          Program Akademik
        </span>
        <h2 class="mt-4 text-3xl sm:text-4xl lg:text-[40px] font-extrabold text-slate-900 tracking-tight leading-[1.18]">
          Belajar teknologi yang dekat
          <span class="text-brand-800 block">dengan kebutuhan industri.</span>
        </h2>
        <p class="mt-4 text-base sm:text-lg text-slate-600 leading-relaxed">
          Kurikulum vokasi terpadu yang dirancang bersama pakar industri untuk mencetak praktisi teknologi informasi yang siap terjun ke dunia kerja nyata.
        </p>
      </div>

      <!-- Editorial Program List with Individual Elevated Cards -->
      <div class="space-y-6">
        <div
          v-for="(prodi, idx) in displayPrograms"
          :key="prodi.id || idx"
          class="bg-white rounded-2xl p-6 sm:p-8 shadow-md border border-slate-200/80 transition-all duration-300 hover:shadow-xl relative z-10 group"
          @mouseenter="activeHoverIndex = idx"
        >
          <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8 items-center">
            
            <!-- 01 / Numbering -->
            <div class="lg:col-span-1 flex items-baseline">
              <span class="font-mono text-xl sm:text-2xl font-bold text-slate-400 group-hover:text-brand-800 transition-colors">
                {{ String(idx + 1).padStart(2, '0') }}
              </span>
            </div>

            <!-- Title & Degree -->
            <div class="lg:col-span-4">
              <div class="flex items-center gap-2 mb-1.5">
                <span class="text-[11px] font-semibold text-brand-700 uppercase tracking-wider">
                  {{ prodi.jenjang || 'Diploma Tiga (D3)' }}
                </span>
                <span class="text-slate-300">•</span>
                <span class="text-[11px] font-medium text-slate-500">
                  Akreditasi {{ prodi.akreditasi || 'Baik' }}
                </span>
              </div>

              <h3 class="text-xl sm:text-2xl font-extrabold text-slate-900 group-hover:text-brand-800 transition-colors tracking-tight">
                <a :href="'/akademik/' + (prodi.slug || '')" class="hover:underline">
                  {{ prodi.nama_prodi }}
                </a>
              </h3>
            </div>

            <!-- Description -->
            <div class="lg:col-span-5">
              <p class="text-sm sm:text-base text-slate-600 leading-relaxed">
                {{ getProdiExcerpt(prodi) }}
              </p>
            </div>

            <!-- Action Link / Arrow -->
            <div class="lg:col-span-2 flex lg:justify-end items-center pt-2 lg:pt-0">
              <a
                :href="'/akademik/' + (prodi.slug || '')"
                class="inline-flex items-center gap-2 text-sm font-bold text-brand-800 group-hover:text-brand-900 transition-all duration-200"
              >
                <span>Lihat Program</span>
                <span class="text-brand-600 group-hover:translate-x-1 transition-transform duration-200">→</span>
              </a>
            </div>

          </div>
        </div>
      </div>

      <!-- Bottom Academic Note Card -->
      <div class="mt-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4 p-6 bg-white rounded-2xl shadow-md border border-slate-200/80 text-xs sm:text-sm text-slate-600 relative z-10">
        <p>Setiap program studi didukung laboratorium komputer berbasis perangkat lunak industri terkini.</p>
        <a href="/akademik" class="font-bold text-brand-800 hover:underline shrink-0">
          Katalog Lengkap Kurikulum &amp; Kalender Akademik →
        </a>
      </div>

    </div>
  </section>
</template>
