<script setup>
import { computed } from 'vue';

const props = defineProps({
  visimisi: {
    type: Object,
    default: () => ({})
  },
  setting: {
    type: Object,
    default: () => ({})
  }
});

// Format paragraphs cleanly from existing database description
const paragraphs = computed(() => {
  if (!props.visimisi?.deskripsi) {
    return [
      'AMIK Taruna Probolinggo adalah institusi pendidikan tinggi vokasi yang berkomitmen menyelenggarakan pembelajaran aplikatif di bidang teknologi informasi dan komputasi bisnis.'
    ];
  }

  return props.visimisi.deskripsi
    .split(/\r\n\r\n|\n\n|\r\r/)
    .map(p => p.trim())
    .filter(p => p.length > 0);
});

// Authentic campus building image from uploads
const buildingPhoto = computed(() => {
  if (props.setting?.hero_slide_1) {
    return '/uploads/' + props.setting.hero_slide_1;
  }
  return '/uploads/1779304106_WhatsApp Image 2026-05-12 at 07.00.25.jpeg';
});
</script>

<template>
  <section id="profil" class="py-16 sm:py-24 border-b border-emerald-900/30 scroll-mt-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      
      <!-- Asymmetric Editorial Card -->
      <div class="card rounded-3xl p-6 sm:p-10 lg:p-12 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-start">
          
          <!-- Left / Content Column (7 cols) -->
          <div class="lg:col-span-7 flex flex-col">
            
            <div class="mb-4">
              <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
                Sekilas Institusi
              </span>
            </div>

            <h2 class="text-2xl sm:text-3xl lg:text-[38px] font-extrabold text-white tracking-tight leading-[1.2]">
              Menumbuhkan keahlian nyata di bidang
              <span class="text-emerald-400 block">teknologi komputasi &amp; digital.</span>
            </h2>

            <!-- Authentic Editorial Paragraphs (Directly from DB) -->
            <div class="mt-6 space-y-4 text-slate-300 leading-relaxed text-base sm:text-lg">
              <p
                v-for="(para, idx) in paragraphs"
                :key="idx"
                :class="idx === 0 ? 'text-white font-medium' : ''"
              >
                {{ para }}
              </p>
            </div>

            <!-- Academic Highlights Pillars (Derived from real description facts) -->
            <div class="mt-10 pt-8 border-t border-emerald-500/20 grid grid-cols-1 sm:grid-cols-3 gap-6">
              <div class="p-4 rounded-xl bg-emerald-950/50 border border-emerald-500/20">
                <span class="text-xs font-mono font-bold text-emerald-400 uppercase tracking-wider block mb-1">
                  Pilar I
                </span>
                <h4 class="text-sm font-bold text-white">Pendidikan Terapan</h4>
                <p class="text-xs text-slate-300 mt-1">
                  Kurikulum terstruktur berbasis praktik &amp; kesiapan kerja industri.
                </p>
              </div>

              <div class="p-4 rounded-xl bg-emerald-950/50 border border-emerald-500/20">
                <span class="text-xs font-mono font-bold text-emerald-400 uppercase tracking-wider block mb-1">
                  Pilar II
                </span>
                <h4 class="text-sm font-bold text-white">Praktisi Berpengalaman</h4>
                <p class="text-xs text-slate-300 mt-1">
                  Dosen dan praktisi kompeten di bidang rekayasa TI &amp; sistem bisnis.
                </p>
              </div>

              <div class="p-4 rounded-xl bg-emerald-950/50 border border-emerald-500/20">
                <span class="text-xs font-mono font-bold text-emerald-400 uppercase tracking-wider block mb-1">
                  Pilar III
                </span>
                <h4 class="text-sm font-bold text-white">Kelanjutan Studi</h4>
                <p class="text-xs text-slate-300 mt-1">
                  Kemudahan transfer SKS ke jenjang sarjana di PTN maupun Swasta.
                </p>
              </div>
            </div>

          </div>

          <!-- Right / Visual Column (5 cols) -->
          <div class="lg:col-span-5 lg:sticky lg:top-28">
            <div class="rounded-2xl overflow-hidden border border-emerald-500/25 shadow-card bg-slate-900/60 group">
              <div class="aspect-[4/3] sm:aspect-[16/11] lg:aspect-[4/3] overflow-hidden">
                <img
                  :src="buildingPhoto"
                  alt="Gedung Kampus AMIK Taruna Probolinggo"
                  class="w-full h-full object-cover group-hover:scale-[1.02] transition-transform duration-700 ease-out"
                  loading="lazy"
                  @error="(e) => { e.target.src = '/uploads/1779304106_WhatsApp Image 2026-05-12 at 07.00.25.jpeg'; }"
                />
              </div>

              <!-- Authentic Building Metadata Footer -->
              <div class="p-5 bg-emerald-950/80 border-t border-emerald-500/20">
                <div class="flex items-center justify-between text-xs text-slate-400 mb-2">
                  <span class="font-bold text-emerald-400 uppercase tracking-wider">Kampus Utama</span>
                  <span class="font-mono text-slate-400">Probolinggo</span>
                </div>
                <h4 class="text-sm font-bold text-white">
                  Gedung Akademik AMIK Taruna
                </h4>
                <p class="text-xs text-slate-300 mt-1 leading-relaxed">
                  {{ setting?.alamat || 'Jl. Raya Dringu No. 168, Kabupaten Probolinggo, Jawa Timur' }}
                </p>

                <div class="mt-4 pt-3 border-t border-emerald-500/20 flex items-center justify-between text-xs text-slate-300 font-medium">
                  <span class="inline-flex items-center gap-1.5 text-emerald-300">
                    <i class="fas fa-check-circle text-emerald-400"></i>
                    Kampus Mandiri
                  </span>
                  <a
                    href="/#lokasi"
                    class="text-emerald-400 hover:text-emerald-300 font-bold inline-flex items-center gap-1 group/link"
                  >
                    <span>Peta Lokasi</span>
                    <span class="group-hover/link:translate-x-0.5 transition-transform">→</span>
                  </a>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>

    </div>
  </section>
</template>
