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
  <section v-if="testimonis && testimonis.length > 0" class="py-16 sm:py-24 bg-gradient-to-b from-[#f8fafc] to-[#f0fdf4] border-t border-slate-200/70 relative overflow-hidden">
    <!-- Background subtle aura -->
    <div class="absolute -top-32 -left-32 w-96 h-96 bg-emerald-500/5 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-32 -right-32 w-96 h-96 bg-teal-500/5 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
      
      <!-- Section Header -->
      <div class="text-center max-w-3xl mx-auto mb-12 sm:mb-16">
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-xs font-bold tracking-wide uppercase bg-emerald-100 text-emerald-800 border border-emerald-200/80 mb-3 shadow-2xs">
          <i class="fas fa-quote-left text-emerald-600 text-[11px]"></i>
          <span>Suara &amp; Jejak Lulusan</span>
        </div>
        <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight leading-tight">
          Kisah Sukses &amp; Testimoni Alumni
        </h2>
        <p class="mt-3 text-sm sm:text-base text-slate-600 leading-relaxed">
          Bukti nyata dedikasi dan kualitas pembelajaran AMIK Taruna yang mengantarkan para alumni berkiprah di dunia kerja, industri digital, dan wirausaha.
        </p>
      </div>

      <!-- Testimonials Grid -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
        <div 
          v-for="t in testimonis" 
          :key="t.id"
          class="bg-white rounded-3xl p-6 sm:p-7 border border-slate-200/90 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 flex flex-col justify-between relative group"
        >
          <!-- Top Card Meta -->
          <div>
            <!-- Star Ratings & Quote Icon -->
            <div class="flex items-center justify-between mb-4">
              <div class="flex items-center gap-1 text-amber-400 text-xs">
                <i 
                  v-for="star in (t.rating || 5)" 
                  :key="star" 
                  class="fas fa-star"
                ></i>
                <span class="text-slate-400 text-xs ml-1 font-semibold">({{ t.rating || 5 }}.0)</span>
              </div>
              <div class="w-8 h-8 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center text-xs group-hover:scale-110 transition-transform">
                <i class="fas fa-quote-right"></i>
              </div>
            </div>

            <!-- Testimonial Quote -->
            <blockquote class="text-slate-700 text-sm sm:text-[14.5px] leading-relaxed italic mb-6">
              "{{ t.testimoni }}"
            </blockquote>
          </div>

          <!-- Bottom: Alumni Identity -->
          <div class="pt-4 border-t border-slate-100 flex items-center gap-3.5 mt-auto">
            <!-- Avatar -->
            <div class="shrink-0">
              <img 
                v-if="t.foto" 
                :src="`/uploads/${t.foto}`" 
                :alt="t.nama" 
                class="w-12 h-12 rounded-full object-cover border-2 border-emerald-500/30 shadow-xs"
                loading="lazy"
              >
              <div 
                v-else 
                class="w-12 h-12 rounded-full bg-gradient-to-br from-emerald-600 to-teal-700 text-white flex items-center justify-center font-bold text-xs tracking-wider shadow-xs"
              >
                {{ getInitials(t.nama) }}
              </div>
            </div>

            <!-- Names & Info -->
            <div class="min-w-0 flex-1">
              <h4 class="text-sm font-bold text-slate-900 truncate">
                {{ t.nama }}
              </h4>

              <!-- Job & Company -->
              <div v-if="t.pekerjaan || t.perusahaan" class="text-xs font-semibold text-emerald-700 truncate mt-0.5">
                {{ t.pekerjaan }}
                <span v-if="t.pekerjaan && t.perusahaan">di</span>
                <span v-if="t.perusahaan" class="text-slate-600 font-medium"> {{ t.perusahaan }}</span>
              </div>

              <!-- Study Program & Year -->
              <div class="flex flex-wrap items-center gap-1.5 mt-1">
                <span v-if="t.program_studi" class="text-[10px] font-semibold text-slate-500 bg-slate-100 px-2 py-0.5 rounded-full">
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
