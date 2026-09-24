<script setup>
import { computed } from 'vue';

const props = defineProps({
  alumniSections: {
    type: Array,
    default: () => []
  }
});

// Fallback items based on real institutional data if array empty
const defaultAlumniItems = [
  {
    id: 1,
    judul: 'Tracer Study Lulusan',
    deskripsi: 'Program pelacakan berkala oleh Kemdiktisaintek untuk memetakan relevansi kurikulum informatika dengan kebutuhan industri serta perkembangan karier lulusan di dunia kerja.',
    image: '1779304106_WhatsApp Image 2026-05-12 at 07.00.25.jpeg',
    link: 'https://tracerstudy.kemdiktisaintek.go.id/',
    badge: 'Karier & Industri'
  },
  {
    id: 2,
    judul: 'Kolaborasi & Dana Abadi Alumni',
    deskripsi: 'Sinergi berkelanjutan alumni AMIK Taruna dalam mendukung pengembangan fasilitas laboratorium komputer, mentoring profesional bagi mahasiswa tingkat akhir, dan beasiswa akademik.',
    image: '1779304083_WhatsApp Image 2026-05-12 at 07.04.36.jpeg',
    link: '/alumni',
    badge: 'Jejaring Sivitas'
  }
];

const displayItems = computed(() => {
  if (props.alumniSections && props.alumniSections.length > 0) {
    return props.alumniSections.map(item => ({
      ...item,
      badge: item.type === 'tracer_study' ? 'Karier & Industri' : 'Jejaring Sivitas'
    }));
  }
  return defaultAlumniItems;
});
</script>

<template>
  <section class="py-16 lg:py-24 border-b border-emerald-900/30 overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      
      <!-- Section Header Card -->
      <div class="max-w-3xl mb-12 bg-white rounded-3xl p-6 sm:p-10 shadow-xl border border-slate-200/80 relative z-10">
        <span class="text-xs font-bold uppercase tracking-widest text-brand-800 bg-brand-50 px-3 py-1 rounded border border-brand-200/70">
          Ikatan Alumni &amp; Rekam Jejak
        </span>
        <h2 class="mt-4 text-3xl sm:text-4xl lg:text-[40px] font-extrabold text-slate-900 tracking-tight leading-[1.18]">
          Jejak lulusan kami
          <span class="text-brand-800 block">di dunia profesional &amp; industri digital.</span>
        </h2>
        <p class="mt-4 text-base sm:text-lg text-slate-600 leading-relaxed">
          Hubungan erat antara almamater dan alumni memperkuat ekosistem penyerapan kerja, umpan balik kurikulum terapan, serta sinergi tridharma berkelanjutan.
        </p>
      </div>

      <!-- Asymmetric Editorial Presentation with Individual Cards -->
      <div class="space-y-10 lg:space-y-12">
        <div
          v-for="(item, idx) in displayItems"
          :key="item.id || idx"
          class="bg-white rounded-3xl p-6 sm:p-10 shadow-xl border border-slate-200/80 relative z-10 grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center"
        >
          
          <!-- Alternating Layout: Odd left image, Even right image -->
          <!-- Image Column (5 cols) -->
          <div
            class="lg:col-span-5"
            :class="idx % 2 === 1 ? 'lg:order-2' : 'lg:order-1'"
          >
            <div class="relative rounded-xl overflow-hidden shadow-card border border-slate-200/80 bg-slate-100 aspect-[16/11] group">
              <img
                :src="item.image ? '/uploads/' + item.image : '/uploads/1779333081_DSC_0075.JPG'"
                :alt="item.judul"
                class="w-full h-full object-cover object-center group-hover:scale-[1.02] transition-transform duration-700 ease-out"
                loading="lazy"
              />
              <div class="absolute inset-0 bg-gradient-to-t from-slate-950/40 via-transparent to-transparent pointer-events-none"></div>
              
              <div class="absolute bottom-3 left-3 z-10">
                <span class="text-[11px] font-bold uppercase tracking-wider px-2.5 py-1 rounded bg-brand-700 text-white shadow-sm">
                  {{ item.badge }}
                </span>
              </div>
            </div>
          </div>

          <!-- Content Column (7 cols) -->
          <div
            class="lg:col-span-7 flex flex-col items-start"
            :class="idx % 2 === 1 ? 'lg:order-1' : 'lg:order-2'"
          >
            <span class="font-mono text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">
              Inisiatif {{ String(idx + 1).padStart(2, '0') }}
            </span>

            <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight leading-snug">
              {{ item.judul }}
            </h3>

            <p class="mt-4 text-base text-slate-600 leading-relaxed max-w-2xl">
              {{ item.deskripsi }}
            </p>

            <div class="mt-7 flex items-center gap-5">
              <a
                v-if="item.link && item.link.startsWith('http')"
                :href="item.link"
                target="_blank"
                rel="noopener"
                class="inline-flex items-center gap-2 text-sm font-bold text-brand-800 hover:text-brand-900 group"
              >
                <span>Portal Resmi Pelacakan Alumni (Kemdiktisaintek)</span>
                <span class="text-brand-600 group-hover:translate-x-1 transition-transform">↗</span>
              </a>
              <a
                v-else
                href="/alumni"
                class="inline-flex items-center gap-2 text-sm font-bold text-brand-800 hover:text-brand-900 group"
              >
                <span>Informasi Ikatan Alumni AMIK Taruna</span>
                <span class="text-brand-600 group-hover:translate-x-1 transition-transform">→</span>
              </a>
            </div>
          </div>

        </div>
      </div>

      <!-- Bottom Editorial Stat / Fact Bar -->
      <div class="mt-16 pt-8 border-t border-slate-200/80 flex flex-col sm:flex-row sm:items-center justify-between gap-4 text-xs sm:text-sm text-slate-500">
        <p>AMIK Taruna secara aktif memelihara komunikasi dengan alumni di berbagai sektor usaha dan instansi.</p>
        <a href="/alumni" class="font-bold text-brand-800 hover:underline shrink-0">
          Kanal Informasi &amp; Layanan Alumni →
        </a>
      </div>

    </div>
  </section>
</template>
