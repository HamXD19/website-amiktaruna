<script setup>
import { ref, onMounted, onUnmounted, computed } from 'vue';
import AppBadge from '../ui/AppBadge.vue';
import AppButton from '../ui/AppButton.vue';

const props = defineProps({
  setting: {
    type: Object,
    default: () => ({})
  }
});

const currentSlide = ref(0);
let slideInterval = null;

const slides = computed(() => {
  const list = [];
  if (props.setting?.hero_slide_1) list.push('/uploads/' + props.setting.hero_slide_1);
  if (props.setting?.hero_slide_2) list.push('/uploads/' + props.setting.hero_slide_2);
  if (props.setting?.hero_slide_3) list.push('/uploads/' + props.setting.hero_slide_3);
  return list;
});

const nextSlide = () => {
  if (slides.value.length > 1) {
    currentSlide.value = (currentSlide.value + 1) % slides.value.length;
  }
};

const prevSlide = () => {
  if (slides.value.length > 1) {
    currentSlide.value = (currentSlide.value - 1 + slides.value.length) % slides.value.length;
  }
};

const goToSlide = (idx) => {
  currentSlide.value = idx;
};

onMounted(() => {
  if (slides.value.length > 1) {
    slideInterval = setInterval(nextSlide, 6000);
  }
});

onUnmounted(() => {
  if (slideInterval) clearInterval(slideInterval);
});

// Helper to filter out generic template claims ('terbaik', 'nomor satu', dll)
const hasAbsoluteClaim = (str) => {
  if (!str) return false;
  const s = str.toLowerCase();
  return s.includes('terbaik') || s.includes('nomor satu') || s.includes('no. 1') || s.includes('selamat datang');
};

// Editorial headline focusing on vocational education + technology + career readiness
const headlinePrimary = computed(() => {
  if (props.setting?.hero_judul && !hasAbsoluteClaim(props.setting.hero_judul)) {
    return props.setting.hero_judul;
  }
  return 'Pendidikan Vokasi Teknologi';
});

const headlineHighlight = computed(() => {
  if (props.setting?.hero_highlight && !hasAbsoluteClaim(props.setting.hero_highlight)) {
    return props.setting.hero_highlight;
  }
  return 'Kesiapan Nyata di Dunia Kerja';
});

const supportingText = computed(() => {
  if (props.setting?.hero_subjudul && !hasAbsoluteClaim(props.setting.hero_subjudul)) {
    return props.setting.hero_subjudul;
  }
  return 'AMIK Taruna membekali mahasiswa dengan keahlian praktis manajemen informatika, kurikulum terapan yang relevan dengan kebutuhan industri, serta integritas kepemimpinan profesional.';
});

const ctaPrimaryText = computed(() => props.setting?.hero_button_1_text || 'Pendaftaran Mahasiswa Baru');
const ctaPrimaryLink = computed(() => props.setting?.hero_button_1_link || '/pmb');

const ctaSecondaryText = computed(() => props.setting?.hero_button_2_text || 'Pelajari Program Studi');
const ctaSecondaryLink = computed(() => props.setting?.hero_button_2_link || '/akademik');
</script>

<template>
  <section class="relative pt-28 pb-14 lg:pt-36 lg:pb-20 border-b border-emerald-900/30">
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10 items-stretch">
        
        <!-- Left Column: Editorial Academic Card -->
        <div class="lg:col-span-7 flex flex-col items-start text-left card rounded-3xl p-6 sm:p-10 relative z-10 justify-between">
          <div>
            <!-- Eyebrow: Clear Institutional Identity -->
            <div class="mb-4">
              <span class="inline-flex items-center gap-2 text-xs font-bold text-emerald-300 tracking-wider uppercase bg-emerald-500/20 px-3 py-1 rounded-md border border-emerald-500/30">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                Akademi Manajemen Informatika &amp; Komputer TARUNA
              </span>
            </div>

            <!-- Headline: Vocational Education + Tech + Career Readiness -->
            <h1 class="text-3xl sm:text-4xl lg:text-[40px] font-extrabold text-white tracking-tight leading-[1.16]">
              {{ headlinePrimary }}
              <span class="block text-emerald-400 font-bold mt-1">
                {{ headlineHighlight }}
              </span>
            </h1>

            <!-- Supporting Text -->
            <p class="mt-4 text-base text-slate-300 leading-relaxed max-w-xl">
              {{ supportingText }}
            </p>

            <!-- Action Buttons -->
            <div class="mt-7 flex flex-wrap items-center gap-3.5 w-full sm:w-auto">
              <AppButton :href="ctaPrimaryLink" variant="accent" size="md" class="w-full sm:w-auto">
                <template #prefix>
                  <i class="fas fa-graduation-cap text-xs"></i>
                </template>
                {{ ctaPrimaryText }}
              </AppButton>

              <AppButton :href="ctaSecondaryLink" variant="secondary" size="md" class="w-full sm:w-auto">
                {{ ctaSecondaryText }}
                <template #suffix>→</template>
              </AppButton>
            </div>
          </div>

          <!-- Editorial Fact Bar -->
          <div class="mt-9 pt-6 border-t border-emerald-500/20 w-full">
            <div class="grid grid-cols-3 gap-3 sm:gap-6 text-left">
              <div>
                <span class="block text-[11px] font-bold uppercase tracking-wider text-slate-400">Status Resmi</span>
                <span class="block text-xs sm:text-sm font-semibold text-emerald-200 mt-0.5">Terakreditasi BAN-PT</span>
              </div>
              <div class="border-l border-emerald-500/20 pl-3 sm:pl-6">
                <span class="block text-[11px] font-bold uppercase tracking-wider text-slate-400">Orientasi</span>
                <span class="block text-xs sm:text-sm font-semibold text-emerald-200 mt-0.5">Vokasi Siap Kerja</span>
              </div>
              <div class="border-l border-emerald-500/20 pl-3 sm:pl-6">
                <span class="block text-[11px] font-bold uppercase tracking-wider text-slate-400">Infrastruktur</span>
                <span class="block text-xs sm:text-sm font-semibold text-emerald-200 mt-0.5">Lab Informatika Modern</span>
              </div>
            </div>
          </div>

        </div>

        <!-- Right Column: Cinematic Photography Card -->
        <div class="lg:col-span-5 card rounded-3xl p-5 sm:p-6 relative z-10 flex flex-col justify-between">
          <div class="relative mx-auto w-full">
            
            <!-- Main Photo Frame: Clean, Grounded, No Excessive Cards or Floating Blobs -->
            <div class="relative rounded-xl overflow-hidden shadow-card border border-emerald-500/30 bg-emerald-950/40 aspect-[4/3] sm:aspect-[16/11]">
              
              <!-- Slide Images -->
              <div v-if="slides.length > 0" class="w-full h-full relative">
                <div
                  v-for="(slide, i) in slides"
                  :key="slide"
                  class="absolute inset-0 transition-opacity duration-700 ease-in-out"
                  :class="currentSlide === i ? 'opacity-100 z-10' : 'opacity-0 z-0 pointer-events-none'"
                >
                  <img
                    :src="slide"
                    alt="Gedung dan Kampus AMIK Taruna"
                    class="w-full h-full object-cover object-center"
                    :loading="i === 0 ? 'eager' : 'lazy'"
                    :fetchpriority="i === 0 ? 'high' : 'low'"
                    width="640"
                    height="440"
                  />
                  <!-- Subtle vignette at bottom for editorial grounding -->
                  <div class="absolute inset-0 bg-gradient-to-t from-slate-950/40 via-transparent to-transparent pointer-events-none"></div>
                </div>
              </div>

              <!-- Fallback if no images uploaded yet -->
              <div v-else class="w-full h-full flex flex-col items-center justify-center bg-slate-900 text-white p-8 text-center">
                <i class="fas fa-university text-3xl text-slate-400 mb-2"></i>
                <h4 class="font-bold text-base text-white">AMIK TARUNA</h4>
                <p class="text-xs text-slate-400 mt-1">Gedung Kampus &amp; Fasilitas Pembelajaran</p>
              </div>

              <!-- Slide Controls (Subtle, if > 1 slide) -->
              <div
                v-if="slides.length > 1"
                class="absolute bottom-3 right-3 z-20 flex items-center gap-1.5 bg-slate-900/60 backdrop-blur-sm px-2.5 py-1 rounded-md"
              >
                <button
                  type="button"
                  class="text-white/80 hover:text-white text-xs px-1"
                  @click="prevSlide"
                  aria-label="Slide Sebelumnya"
                >
                  ‹
                </button>
                <span class="text-[11px] font-mono text-white/90">
                  {{ currentSlide + 1 }}/{{ slides.length }}
                </span>
                <button
                  type="button"
                  class="text-white/80 hover:text-white text-xs px-1"
                  @click="nextSlide"
                  aria-label="Slide Selanjutnya"
                >
                  ›
                </button>
              </div>

            </div>

            <!-- Editorial Caption Bar Below Photo (Replaced Floating SaaS Badge) -->
            <div class="mt-3 flex items-center justify-between px-1 text-xs text-slate-300">
              <div class="flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                <span class="font-medium text-emerald-200">Penerimaan Mahasiswa Baru Gelombang 2026/2027 Dibuka</span>
              </div>
              <a href="/pmb" class="font-bold text-emerald-400 hover:text-emerald-300 hover:underline">
                Info PMB →
              </a>
            </div>

          </div>
        </div>

      </div>
    </div>

  </section>
</template>
