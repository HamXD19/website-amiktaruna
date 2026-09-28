<script setup>
import { computed } from 'vue';

const props = defineProps({
  setting: {
    type: Object,
    default: () => ({})
  }
});

const defaultPillars = [
  {
    icon: 'fas fa-chart-line',
    title: 'Relevansi Kurikulum',
    desc: 'Tracer study memetakan kesesuaian keahlian lulusan dengan kebutuhan nyata industri teknologi masa kini.',
    badge: 'Pilar Pengembangan'
  },
  {
    icon: 'fas fa-network-wired',
    title: 'Jejaring Profesional',
    desc: 'Menghubungkan lulusan lintas angkatan yang berkarier di institusi pemerintah, BUMN, dan industri kreatif.',
    badge: 'Pilar Kolaborasi'
  },
  {
    icon: 'fas fa-hand-holding-heart',
    title: 'Dukungan Fasilitas',
    desc: 'Sinergi dana abadi membantu penyediaan fasilitas laboratorium serta beasiswa bagi mahasiswa berprestasi.',
    badge: 'Pilar Solidaritas'
  }
];

const pillars = computed(() => {
  if (props.setting?.alumni_pillars && Array.isArray(props.setting.alumni_pillars) && props.setting.alumni_pillars.length > 0) {
    return props.setting.alumni_pillars;
  }
  return defaultPillars;
});
</script>

<template>
  <section class="py-16 sm:py-20 relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      
      <div class="max-w-3xl">
        <span class="inline-flex items-center gap-1.5 text-xs font-bold uppercase tracking-widest text-emerald-300 bg-emerald-500/20 px-3 py-1 rounded-full border border-emerald-500/30">
          Komitmen Sinergi
        </span>
        <h2 class="mt-4 text-2xl sm:text-3xl lg:text-[36px] font-extrabold text-white tracking-tight leading-[1.2]">
          Menjaga ikatan berharga,
          <span class="text-emerald-400 block">mengokohkan masa depan generasi penerus.</span>
        </h2>
        <p class="mt-4 text-base sm:text-lg text-slate-300 leading-relaxed">
          Hubungan antara AMIK Taruna dan para lulusan senantiasa terjaga secara berkelanjutan. Masukan dari dunia kerja serta kontribusi alumni menjadi fondasi utama dalam meningkatkan mutu pendidikan terapan di kampus.
        </p>
      </div>

      <!-- 3 Editorial Pillars -->
      <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8">
        
        <div
          v-for="(pillar, idx) in pillars"
          :key="idx"
          class="card p-6 rounded-2xl border border-emerald-500/20 border-t-2 border-t-emerald-400 shadow-lg flex flex-col justify-between"
        >
          <div>
            <div class="w-10 h-10 rounded-xl bg-emerald-500/20 border border-emerald-500/30 flex items-center justify-center text-emerald-300 mb-4">
              <i :class="[pillar.icon || 'fas fa-check', 'text-sm']"></i>
            </div>
            <h3 class="text-base font-bold text-white">{{ pillar.title }}</h3>
            <p class="text-xs sm:text-sm text-slate-300 mt-2 leading-relaxed">
              {{ pillar.desc }}
            </p>
          </div>
          <span class="mt-6 text-[11px] font-mono text-emerald-400 font-semibold">{{ pillar.badge }}</span>
        </div>

      </div>

    </div>
  </section>
</template>
