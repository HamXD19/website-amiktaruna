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

// Clean excerpt for homepage storytelling without dumping large database paragraphs
const aboutExcerpt = computed(() => {
  if (props.visimisi?.deskripsi && props.visimisi.deskripsi.length > 20) {
    // Trim if too long, maximum 220 characters
    return props.visimisi.deskripsi.length > 240
      ? props.visimisi.deskripsi.substring(0, 240) + '...'
      : props.visimisi.deskripsi;
  }
  return 'AMIK Taruna adalah perguruan tinggi vokasi yang berfokus pada keahlian terapan di bidang informatika dan teknologi komputasi, membina lulusan yang tanggap terhadap transformasi industri digital.';
});

const visiStatement = computed(() => {
  return props.visimisi?.visi || 'Menjadi perguruan tinggi vokasi unggul dan berdaya saing dalam menghasilkan profesional di bidang teknologi informasi dan komunikasi.';
});

// Format mission items cleanly from string (handles newlines or numbers)
const misiItems = computed(() => {
  if (!props.visimisi?.misi) {
    return [
      'Menyelenggarakan pendidikan vokasi berkualitas yang berorientasi pada penguasaan teknologi terapan.',
      'Melaksanakan penelitian aplikatif yang berkontribusi nyata bagi dunia usaha dan industri.',
      'Menjalin kemitraan strategis guna memperluas penyerapan lulusan di pasar kerja digital.'
    ];
  }

  // Split by newline or numbered patterns
  const lines = props.visimisi.misi
    .split(/\r\n|\n|\r/)
    .map(line => line.trim())
    .filter(line => line.length > 5)
    .map(line => line.replace(/^\d+[\.\)]\s*/, '')); // remove leading "1. " or "1) "

  return lines.length > 0 ? lines : [props.visimisi.misi];
});

// Authentic photo candidate from existing uploads
const aboutPhoto = computed(() => {
  return '/uploads/1779333081_DSC_0075.JPG';
});
</script>

<template>
  <section class="py-16 lg:py-24 border-b border-emerald-900/30 overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      
      <!-- Part 1: Asymmetric Editorial About Card -->
      <div class="bg-white rounded-3xl p-6 sm:p-12 shadow-xl border border-slate-200/80 mb-10 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-14 items-center">
          
          <!-- Left Column: Story Content -->
          <div class="lg:col-span-6 flex flex-col items-start">
            
            <div class="mb-4">
              <span class="text-xs font-bold uppercase tracking-widest text-brand-800 bg-brand-50 px-3 py-1 rounded border border-brand-200/70">
                Tentang AMIK Taruna
              </span>
            </div>

            <h2 class="text-3xl sm:text-4xl lg:text-[40px] font-extrabold text-slate-900 tracking-tight leading-[1.18]">
              Tempat teknologi,
              <span class="text-brand-800 block">pendidikan vokasi,</span>
              dan masa depan bertemu.
            </h2>

            <p class="mt-6 text-base sm:text-lg text-slate-600 leading-relaxed max-w-xl">
              {{ aboutExcerpt }}
            </p>

            <div class="mt-8 flex items-center gap-6">
              <a
                href="/tentang"
                class="inline-flex items-center gap-2.5 text-sm sm:text-base font-bold text-brand-800 hover:text-brand-900 group"
              >
                <span>Kenali AMIK Taruna Lebih Dekat</span>
                <span class="text-brand-600 group-hover:translate-x-1.5 transition-transform duration-200">→</span>
              </a>
            </div>

          </div>

          <!-- Right Column: Large Authentic Institutional Image -->
          <div class="lg:col-span-6">
            <div class="relative">
              <div class="rounded-xl overflow-hidden shadow-card border border-slate-200/80 bg-slate-100 aspect-[4/3] sm:aspect-[16/11]">
                <img
                  :src="aboutPhoto"
                  alt="Civitas Akademika AMIK Taruna"
                  class="w-full h-full object-cover object-center hover:scale-[1.02] transition-transform duration-700 ease-out"
                  loading="lazy"
                  @error="(e) => { e.target.src = '/uploads/' + (setting?.hero_slide_1 || ''); }"
                />
              </div>

              <!-- Subtle Editorial Meta Caption -->
              <div class="mt-3 flex items-center justify-between text-xs text-slate-500 px-1 font-medium">
                <span>Aktivitas &amp; Lingkungan Akademik Kampus</span>
                <span class="font-mono text-slate-400">AMIK Taruna Probolinggo</span>
              </div>
            </div>
          </div>

        </div>
      </div>

      <!-- Part 2: Editorial Vision & Mission Card -->
      <div class="bg-white rounded-3xl p-6 sm:p-12 shadow-xl border border-slate-200/80 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-14">
          
          <!-- Vision Block (01 — VISI) -->
          <div class="lg:col-span-5 flex flex-col justify-between">
            <div>
              <span class="text-xs font-mono font-bold tracking-wider text-brand-800 uppercase">
                01 — VISI INSTITUSI
              </span>
              <p class="mt-4 text-xl sm:text-2xl font-bold text-slate-900 leading-snug tracking-tight">
                "{{ visiStatement }}"
              </p>
            </div>
            <div class="mt-6 hidden lg:block text-xs text-slate-400 font-medium">
              Arah haluan strategis pengembangan tridharma perguruan tinggi.
            </div>
          </div>

          <!-- Divider for Desktop -->
          <div class="hidden lg:block lg:col-span-1 flex justify-center">
            <div class="w-px h-full bg-slate-200"></div>
          </div>

          <!-- Mission Block (02 — MISI) -->
          <div class="lg:col-span-6">
            <span class="text-xs font-mono font-bold tracking-wider text-brand-800 uppercase">
              02 — MISI AKADEMIK
            </span>

            <ul class="mt-5 space-y-4">
              <li
                v-for="(item, idx) in misiItems"
                :key="idx"
                class="flex items-start gap-4 text-sm sm:text-base text-slate-700 leading-relaxed"
              >
                <span class="font-mono text-xs font-bold text-brand-700 bg-brand-50 border border-brand-200/70 px-2 py-0.5 rounded shrink-0 mt-0.5">
                  {{ String(idx + 1).padStart(2, '0') }}
                </span>
                <span>{{ item }}</span>
              </li>
            </ul>

            <div class="mt-6 pt-4 border-t border-slate-100">
              <a
                href="/tentang#visi-misi"
                class="text-xs font-bold text-slate-500 hover:text-brand-800 transition-colors inline-flex items-center gap-1.5"
              >
                <span>Lihat rincian tujuan &amp; sasaran mutu</span>
                <span>→</span>
              </a>
            </div>
          </div>

        </div>
      </div>

    </div>
  </section>
</template>
