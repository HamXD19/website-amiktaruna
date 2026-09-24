<script setup>
defineProps({
  alumniSections: {
    type: Array,
    default: () => []
  }
});

const getSectionId = (type, index) => {
  if (type === 'tracer_study') return 'tracer-study';
  if (type === 'dana_abadi') return 'dana-abadi';
  return 'alumni-section-' + index;
};
</script>

<template>
  <section class="py-16 sm:py-24 relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      
      <!-- Empty State -->
      <div
        v-if="!alumniSections || alumniSections.length === 0"
        class="card text-center py-20 px-4 rounded-2xl border border-emerald-500/20 shadow-lg max-w-2xl mx-auto"
      >
        <div class="w-16 h-16 rounded-full bg-emerald-500/20 text-emerald-300 flex items-center justify-center mx-auto mb-4 border border-emerald-500/30">
          <i class="fas fa-user-graduate text-2xl"></i>
        </div>
        <h3 class="text-lg font-bold text-white">Belum Ada Informasi Alumni</h3>
        <p class="text-sm text-slate-300 mt-2 leading-relaxed">
          Informasi tracer study dan program alumni sedang dalam pembaruan berkala.
        </p>
      </div>

      <!-- Content Sections List -->
      <div v-else class="space-y-20 lg:space-y-28">
        <article
          v-for="(item, index) in alumniSections"
          :key="item.id"
          :id="getSectionId(item.type, index)"
          class="scroll-mt-24"
        >
          <!-- Asymmetric Editorial Row -->
          <div
            class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-16 items-center"
            :class="item.layout === 'right_image' ? 'lg:flex-row-reverse' : ''"
          >
            
            <!-- IMAGE COLUMN (5 cols) -->
            <div
              class="lg:col-span-5"
              :class="item.layout === 'right_image' ? 'lg:order-2' : 'lg:order-1'"
            >
              <div class="card rounded-2xl overflow-hidden border border-emerald-500/25 shadow-xl group">
                <div class="aspect-[4/3] sm:aspect-[16/11] lg:aspect-[4/3] overflow-hidden bg-slate-900">
                  <img
                    v-if="item.image"
                    :src="'/uploads/' + item.image"
                    :alt="item.judul"
                    class="w-full h-full object-cover group-hover:scale-[1.03] transition-transform duration-700 ease-out"
                    loading="lazy"
                    @error="(e) => { e.target.style.display = 'none'; }"
                  />
                  <!-- Fallback illustration if image missing -->
                  <div
                    v-else
                    class="w-full h-full flex flex-col items-center justify-center p-8 bg-gradient-to-br from-emerald-950 to-emerald-900 text-emerald-300"
                  >
                    <i class="fas fa-university text-5xl mb-3 opacity-60"></i>
                    <span class="text-xs font-bold uppercase tracking-wider">AMIK Taruna Probolinggo</span>
                  </div>
                </div>

                <!-- Editorial Meta Caption -->
                <div class="p-4 border-t border-emerald-500/20 flex items-center justify-between text-xs text-slate-300 bg-emerald-950/40">
                  <span class="font-medium">Dokumentasi &amp; Sivitas Kampus</span>
                  <span class="font-mono text-emerald-400 font-semibold">AMIK Taruna</span>
                </div>
              </div>
            </div>

            <!-- TEXT CONTENT COLUMN (7 cols) -->
            <div
              class="lg:col-span-7 flex flex-col items-start"
              :class="item.layout === 'right_image' ? 'lg:order-1' : 'lg:order-2'"
            >
              
              <!-- Badge Type -->
              <div class="mb-4">
                <span
                  v-if="item.type === 'tracer_study'"
                  class="inline-flex items-center gap-1.5 text-xs font-bold uppercase tracking-wider text-emerald-300 bg-emerald-500/20 px-3.5 py-1.5 rounded-full border border-emerald-500/30"
                >
                  <i class="fas fa-user-graduate text-[11px]"></i>
                  Tracer Study Resmi
                </span>
                <span
                  v-else-if="item.type === 'dana_abadi'"
                  class="inline-flex items-center gap-1.5 text-xs font-bold uppercase tracking-wider text-amber-300 bg-amber-500/20 px-3.5 py-1.5 rounded-full border border-amber-500/30"
                >
                  <i class="fas fa-hand-holding-heart text-[11px]"></i>
                  Program Dana Abadi Kampus
                </span>
                <span
                  v-else
                  class="inline-flex items-center gap-1.5 text-xs font-bold uppercase tracking-wider text-emerald-300 bg-emerald-500/20 px-3.5 py-1.5 rounded-full border border-emerald-500/30"
                >
                  Program Alumni
                </span>
              </div>

              <!-- Title -->
              <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-white tracking-tight leading-snug">
                {{ item.judul }}
              </h2>

              <!-- Description -->
              <p class="mt-5 text-base sm:text-lg text-slate-300 leading-relaxed">
                {{ item.deskripsi }}
              </p>

              <!-- Action Link / Button -->
              <div class="mt-8 flex flex-wrap items-center gap-4">
                <a
                  v-if="item.link && item.link !== '#'"
                  :href="item.link"
                  target="_blank"
                  rel="noopener noreferrer"
                  class="inline-flex items-center gap-2.5 px-6 py-3.5 rounded-xl font-bold text-sm sm:text-base bg-[#16a34a] hover:bg-[#15803d] text-white shadow-sm hover:shadow-md transition-all duration-200 hover:-translate-y-0.5 group/btn"
                >
                  <i
                    :class="item.type === 'tracer_study' ? 'fas fa-clipboard-check' : 'fas fa-hand-holding-heart'"
                    class="text-emerald-200"
                  ></i>
                  <span>{{ item.type === 'tracer_study' ? 'Isi Kuesioner Tracer Study' : 'Informasi &amp; Partisipasi' }}</span>
                  <span class="text-emerald-300 group-hover/btn:translate-x-1 transition-transform">→</span>
                </a>

                <!-- Helper text for official Kemdiktisaintek portal -->
                <span
                  v-if="item.type === 'tracer_study'"
                  class="text-xs text-slate-400 font-medium flex items-center gap-1.5"
                >
                  <i class="fas fa-shield-alt text-emerald-400"></i>
                  Terintegrasi portal resmi Kemdiktisaintek
                </span>
              </div>

            </div>

          </div>
        </article>
      </div>

    </div>
  </section>
</template>
