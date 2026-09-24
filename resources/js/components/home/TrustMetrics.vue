<script setup>
import SectionHeader from '../ui/SectionHeader.vue';

defineProps({
  prodis: {
    type: Array,
    default: () => []
  }
});

const pillars = [
  {
    icon: 'badge-check',
    title: 'Terakreditasi Resmi',
    desc: 'Memiliki legalitas dan pengakuan resmi dari BAN-PT sebagai institusi pendidikan tinggi vokasi yang terpercaya.',
    badge: 'Legal & Kredibel'
  },
  {
    icon: 'code-laptop',
    title: 'Kurikulum Terapan',
    desc: 'Proporsi praktik komputasi dan teknologi informasi yang dominan guna memastikan kesiapan kerja lulusan.',
    badge: '70% Praktik'
  },
  {
    icon: 'users-academic',
    title: 'Dosen Berpengalaman',
    desc: 'Dibimbing oleh para akademisi dan praktisi profesional di bidang manajemen informatika dan teknologi.',
    badge: 'Kompeten'
  },
  {
    icon: 'career-growth',
    title: 'Peluang Karier Luas',
    desc: 'Keahlian digital yang dicari di berbagai sektor: instansi pemerintah, BUMN, perbankan, industri kreatif, dan startup.',
    badge: 'Siap Kerja'
  }
];
</script>

<template>
  <section class="py-16 sm:py-20 bg-white border-y border-slate-200/70 relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      
      <!-- Section Header -->
      <SectionHeader
        eyebrow="Komitmen Mutu & Keunggulan"
        title="Mengapa Memilih AMIK Taruna?"
        subtitle="Mempersiapkan generasi masa depan dengan kompetensi teknologi informasi, kemampuan manajerial, dan etika profesional."
      />

      <!-- 4 Pillars Grid -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div
          v-for="(pillar, idx) in pillars"
          :key="pillar.title"
          class="card rounded-2xl p-6 transition-all duration-300 hover:-translate-y-1 flex flex-col justify-between group"
        >
          <div>
            <!-- Icon & Micro-Badge -->
            <div class="flex items-center justify-between mb-4">
              <div class="w-11 h-11 rounded-lg bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 flex items-center justify-center group-hover:bg-emerald-600 group-hover:text-white transition-colors duration-200">
                <!-- SVG Icons mapped by icon string -->
                <svg v-if="pillar.icon === 'badge-check'" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
                <svg v-else-if="pillar.icon === 'code-laptop'" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                <svg v-else-if="pillar.icon === 'users-academic'" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                <svg v-else class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                </svg>
              </div>

              <span class="text-[11px] font-bold tracking-wider text-emerald-300 bg-emerald-950/80 border border-emerald-500/30 px-2.5 py-1 rounded-md">
                {{ pillar.badge }}
              </span>
            </div>

            <!-- Title -->
            <h3 class="text-base font-bold text-white group-hover:text-emerald-300 transition-colors">
              {{ pillar.title }}
            </h3>

            <!-- Description -->
            <p class="mt-2 text-xs sm:text-sm text-slate-300 leading-relaxed">
              {{ pillar.desc }}
            </p>
          </div>

          <!-- Bottom Micro-line (subtle indication of precision) -->
          <div class="mt-5 pt-3 border-t border-emerald-500/20 flex items-center justify-between text-xs font-semibold text-emerald-400">
            <span>Keunggulan AMIK</span>
            <span class="text-slate-400 group-hover:translate-x-1 group-hover:text-emerald-300 transition-all">→</span>
          </div>
        </div>
      </div>

    </div>
  </section>
</template>
