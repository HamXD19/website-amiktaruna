<script setup>
import { computed } from 'vue';

const props = defineProps({
  visimisi: {
    type: Object,
    default: () => ({})
  }
});

// Visi statement
const visi = computed(() => {
  return props.visimisi?.visi || 'Menjadi perguruan tinggi yang berkualitas di bidang informatika dan komputer, menghasilkan lulusan yang unggul dan mandiri.';
});

// Parse misi into list cleanly without losing original meaning
const misiItems = computed(() => {
  if (!props.visimisi?.misi) {
    return [
      'Menyelenggarakan pendidikan tinggi yang berkualitas dan efisien dalam bidang Sistem Informasi.',
      'Menghasilkan lulusan yang beriman dan bertakwa kepada Tuhan Yang Maha Esa.',
      'Menghasilkan lulusan yang memiliki keunggulan kompetitif dan mandiri.',
      'Menjadi pusat pelayanan persiapan dan pengembangan karir terbaik bagi mahasiswa/alumni.'
    ];
  }

  // Split by newline
  const lines = props.visimisi.misi
    .split(/\r\n|\n|\r/)
    .map(l => l.trim())
    .filter(l => l.length > 3)
    .map(l => l.replace(/^\d+[\.\)]\s*/, '')); // remove leading number prefix like "1. " to renumber cleanly in UI

  return lines.length > 0 ? lines : [props.visimisi.misi];
});
</script>

<template>
  <section id="visi-misi" class="py-20 lg:py-28 border-b border-emerald-900/30 scroll-mt-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      
      <!-- Section Header Eyebrow -->
      <div class="card rounded-3xl p-6 sm:p-10 mb-12 text-center max-w-3xl mx-auto relative z-10">
        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
          Landasan Filosofis
        </span>
        <h2 class="mt-4 text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white tracking-tight">
          Visi &amp; Misi Institusi
        </h2>
        <p class="mt-4 text-base sm:text-lg text-slate-300 leading-relaxed">
          Arah haluan strategis, nilai luhur, dan komitmen penyelenggaraan tridharma perguruan tinggi AMIK Taruna.
        </p>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-start">
        
        <!-- VISI SECTION: Visual Focal Point -->
        <div class="lg:col-span-6 flex flex-col justify-between h-full card rounded-3xl p-8 sm:p-12 relative overflow-hidden">
          <div class="relative z-10">
            <div class="flex items-center gap-3">
              <span class="font-mono text-xs font-bold text-emerald-300 bg-emerald-500/20 px-3 py-1 rounded-lg border border-emerald-500/30">
                01 / VISI
              </span>
              <span class="text-xs font-bold uppercase tracking-widest text-emerald-400">
                Arah Capaian Utama
              </span>
            </div>

            <!-- Large Quote / Statement -->
            <blockquote class="mt-8 text-2xl sm:text-3xl lg:text-3xl font-extrabold text-white tracking-tight leading-snug">
              "{{ visi }}"
            </blockquote>
          </div>

          <div class="mt-10 pt-6 border-t border-emerald-500/20 flex items-center justify-between text-xs text-slate-300 font-medium relative z-10">
            <span>Standar Capaian Institusi</span>
            <span class="font-mono text-emerald-400 font-semibold">AMIK Taruna Probolinggo</span>
          </div>
        </div>

        <!-- MISI SECTION: Numbered Editorial List (01, 02, 03, ...) -->
        <div class="lg:col-span-6 flex flex-col">
          
          <div class="flex items-center gap-3 mb-6">
            <span class="font-mono text-xs font-bold text-emerald-300 bg-emerald-500/20 px-3 py-1 rounded-lg border border-emerald-500/30">
              02 / MISI
            </span>
            <span class="text-xs font-bold uppercase tracking-widest text-emerald-400">
              Tridharma &amp; Mutu Akademik
            </span>
          </div>

          <div class="space-y-4">
            <div
              v-for="(item, idx) in misiItems"
              :key="idx"
              class="p-6 card rounded-2xl flex items-start gap-5 group transition-all"
            >
              <!-- Prominent Monospace Number -->
              <span class="font-mono text-base font-bold text-emerald-300 bg-emerald-500/20 border border-emerald-500/30 px-3.5 py-1.5 rounded-lg shrink-0 group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                {{ String(idx + 1).padStart(2, '0') }}
              </span>

              <div class="flex-1">
                <p class="text-base text-slate-200 leading-relaxed font-medium">
                  {{ item }}
                </p>
              </div>
            </div>
          </div>

        </div>

      </div>

    </div>
  </section>
</template>
