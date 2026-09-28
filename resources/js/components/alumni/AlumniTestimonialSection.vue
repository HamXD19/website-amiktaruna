<script setup>
defineProps({
  testimonis: {
    type: Array,
    default: () => []
  }
});

const getInitials = (name) => {
  if (!name) return 'AL';
  const parts = name.trim().split(' ');
  if (parts.length >= 2) {
    return (parts[0][0] + parts[1][0]).toUpperCase();
  }
  return name.slice(0, 2).toUpperCase();
};
</script>

<template>
  <section v-if="testimonis && testimonis.length > 0" class="py-16 sm:py-24 relative overflow-hidden" id="testimoni-alumni">
    <!-- Subtle Ambient Green Light -->
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[700px] h-[400px] bg-emerald-500/5 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
      
      <!-- Section Header -->
      <div class="text-center max-w-3xl mx-auto mb-12 sm:mb-16">
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-xs font-bold tracking-widest uppercase bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 mb-3 shadow-xs">
          <i class="fas fa-quote-left text-emerald-400 text-[11px]"></i>
          <span>Suara &amp; Jejak Lulusan</span>
        </div>
        <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-white tracking-tight leading-tight">
          Kisah Sukses &amp; Testimoni Alumni
        </h2>
        <p class="mt-3 text-sm sm:text-base text-slate-300 leading-relaxed max-w-2xl mx-auto">
          Bukti nyata dedikasi dan kualitas pembelajaran AMIK Taruna yang mengantarkan para alumni berkiprah di dunia kerja, industri digital, dan wirausaha.
        </p>
      </div>

      <!-- Testimonials Grid -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
        <div 
          v-for="t in testimonis" 
          :key="t.id"
          class="card p-6 sm:p-7 rounded-3xl border border-emerald-500/25 shadow-xl hover:border-emerald-400/50 hover:-translate-y-1.5 transition-all duration-300 flex flex-col justify-between group"
        >
          <!-- Top: Meta Rating & Quote Icon -->
          <div>
            <div class="flex items-center justify-between mb-4">
              <div class="flex items-center gap-1 text-amber-400 text-xs">
                <i 
                  v-for="star in (t.rating || 5)" 
                  :key="star" 
                  class="fas fa-star"
                ></i>
                <span class="text-slate-400 text-xs ml-1 font-semibold">({{ t.rating || 5 }}.0)</span>
              </div>
              <div class="w-8 h-8 rounded-xl bg-emerald-500/20 border border-emerald-500/30 text-emerald-300 flex items-center justify-center text-xs group-hover:scale-110 transition-transform">
                <i class="fas fa-quote-right"></i>
              </div>
            </div>

            <!-- Quote Text -->
            <blockquote class="text-slate-200 text-sm sm:text-[14.5px] leading-relaxed italic mb-6">
              "{{ t.testimoni }}"
            </blockquote>
          </div>

          <!-- Bottom: Alumni Identity -->
          <div class="pt-4 border-t border-emerald-500/20 flex items-center gap-3.5 mt-auto">
            <!-- Avatar -->
            <div class="shrink-0">
              <img 
                v-if="t.foto" 
                :src="`/uploads/${t.foto}`" 
                :alt="t.nama" 
                class="w-12 h-12 rounded-full object-cover border-2 border-emerald-400/40 shadow-xs"
                loading="lazy"
                @error="(e) => { e.target.style.display = 'none'; }"
              >
              <div 
                v-else 
                class="w-12 h-12 rounded-full bg-gradient-to-br from-emerald-600 to-teal-800 text-white flex items-center justify-center font-bold text-xs tracking-wider border border-emerald-400/30 shadow-xs"
              >
                {{ getInitials(t.nama) }}
              </div>
            </div>

            <!-- Author details -->
            <div class="min-w-0 flex-1">
              <h4 class="text-sm font-bold text-white truncate">
                {{ t.nama }}
              </h4>

              <!-- Job & Company -->
              <div v-if="t.pekerjaan || t.perusahaan" class="text-xs font-semibold text-emerald-400 truncate mt-0.5">
                {{ t.pekerjaan }}
                <span v-if="t.pekerjaan && t.perusahaan" class="text-slate-400 font-normal"> di </span>
                <span v-if="t.perusahaan" class="text-slate-300 font-medium">{{ t.perusahaan }}</span>
              </div>

              <!-- Study Program & Graduation Year -->
              <div class="flex flex-wrap items-center gap-1.5 mt-1.5">
                <span v-if="t.program_studi" class="text-[10px] font-semibold text-emerald-300 bg-emerald-950/70 border border-emerald-500/25 px-2 py-0.5 rounded-full">
                  {{ t.program_studi }}
                </span>
                <span v-if="t.tahun_lulus" class="text-[10px] text-slate-400">
                  • Lulus {{ t.tahun_lulus }}
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>
</template>
