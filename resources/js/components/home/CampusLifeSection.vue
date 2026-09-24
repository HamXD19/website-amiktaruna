<script setup>
const photos = [
  {
    src: '/uploads/1779333051_DSC_0081.JPG',
    title: 'Praktikum Komputasi & Pemrograman',
    category: 'Laboratorium',
    aspect: 'aspect-[4/3] lg:aspect-[4/5]'
  },
  {
    src: '/uploads/1779333067_DSC_0073.JPG',
    title: 'Interaksi Belajar & Pembimbingan Dosen',
    category: 'Akademik',
    aspect: 'aspect-[16/10]'
  },
  {
    src: '/uploads/1779333097_DSC_0071.JPG',
    title: 'Kolaborasi Proyek Teknologi Mahasiswa',
    category: 'Aktivitas',
    aspect: 'aspect-[16/10]'
  },
  {
    src: '/uploads/1779333114_DSC_0068.JPG',
    title: 'Suasana Perkuliahan Terapan',
    category: 'Kampus',
    aspect: 'aspect-[16/10] lg:aspect-[21/9]'
  }
];
</script>

<template>
  <section class="py-16 lg:py-24 border-b border-emerald-900/30">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      
      <!-- Section Header Card -->
      <div class="flex flex-col md:flex-row md:items-end justify-between mb-10 gap-6 bg-white rounded-3xl p-6 sm:p-10 shadow-xl border border-slate-200/80 relative z-10">
        <div class="max-w-2xl">
          <span class="text-xs font-bold uppercase tracking-widest text-brand-800 bg-brand-50 px-3 py-1 rounded border border-brand-200/70">
            Kehidupan Kampus
          </span>
          <h2 class="mt-4 text-3xl sm:text-4xl lg:text-[40px] font-extrabold text-slate-900 tracking-tight leading-[1.18]">
            Dinamika belajar nyata
            <span class="text-brand-800 block">dalam atmosfer profesional.</span>
          </h2>
          <p class="mt-4 text-base text-slate-600 leading-relaxed">
            Dokumentasi autentik aktivitas pembelajaran, kolaborasi di laboratorium, dan kehidupan sivitas akademika AMIK Taruna.
          </p>
        </div>

        <div class="text-xs font-mono text-slate-400 font-medium self-start md:self-end">
          Dokumentasi Resmi Sivitas
        </div>
      </div>

      <!-- Asymmetric Editorial Collage (Not a generic 3x3 grid) -->
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-stretch">
        
        <!-- Large Anchor Image (Left, 5 cols) -->
        <div class="lg:col-span-5 flex flex-col">
          <div class="relative rounded-xl overflow-hidden shadow-card border border-slate-200/80 bg-slate-100 flex-1 group aspect-[4/3] lg:aspect-auto">
            <img
              :src="photos[0].src"
              :alt="photos[0].title"
              class="w-full h-full object-cover object-center group-hover:scale-[1.03] transition-transform duration-700 ease-out"
              loading="lazy"
            />
            <!-- Subtle gradient vignette for text legibility -->
            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/70 via-transparent to-transparent opacity-80 group-hover:opacity-90 transition-opacity duration-300 pointer-events-none"></div>

            <div class="absolute bottom-4 left-4 right-4 z-10 text-white">
              <span class="text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded bg-brand-700 text-white mb-1.5 inline-block">
                {{ photos[0].category }}
              </span>
              <p class="text-sm sm:text-base font-bold text-white leading-snug">
                {{ photos[0].title }}
              </p>
            </div>
          </div>
        </div>

        <!-- Collage Stack (Right, 7 cols) -->
        <div class="lg:col-span-7 flex flex-col gap-6">
          
          <!-- Top Row (2 Columns) -->
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            
            <div class="relative rounded-xl overflow-hidden shadow-card border border-slate-200/80 bg-slate-100 aspect-[16/10] group">
              <img
                :src="photos[1].src"
                :alt="photos[1].title"
                class="w-full h-full object-cover object-center group-hover:scale-[1.03] transition-transform duration-700 ease-out"
                loading="lazy"
              />
              <div class="absolute inset-0 bg-gradient-to-t from-slate-950/70 via-transparent to-transparent opacity-80 group-hover:opacity-90 transition-opacity duration-300 pointer-events-none"></div>
              <div class="absolute bottom-3 left-3 right-3 z-10 text-white">
                <span class="text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded bg-slate-900/80 text-white mb-1 inline-block">
                  {{ photos[1].category }}
                </span>
                <p class="text-xs sm:text-sm font-bold text-white leading-snug">
                  {{ photos[1].title }}
                </p>
              </div>
            </div>

            <div class="relative rounded-xl overflow-hidden shadow-card border border-slate-200/80 bg-slate-100 aspect-[16/10] group">
              <img
                :src="photos[2].src"
                :alt="photos[2].title"
                class="w-full h-full object-cover object-center group-hover:scale-[1.03] transition-transform duration-700 ease-out"
                loading="lazy"
              />
              <div class="absolute inset-0 bg-gradient-to-t from-slate-950/70 via-transparent to-transparent opacity-80 group-hover:opacity-90 transition-opacity duration-300 pointer-events-none"></div>
              <div class="absolute bottom-3 left-3 right-3 z-10 text-white">
                <span class="text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded bg-slate-900/80 text-white mb-1 inline-block">
                  {{ photos[2].category }}
                </span>
                <p class="text-xs sm:text-sm font-bold text-white leading-snug">
                  {{ photos[2].title }}
                </p>
              </div>
            </div>

          </div>

          <!-- Bottom Wide Image -->
          <div class="relative rounded-xl overflow-hidden shadow-card border border-slate-200/80 bg-slate-100 aspect-[16/9] lg:aspect-[21/9] group flex-1">
            <img
              :src="photos[3].src"
              :alt="photos[3].title"
              class="w-full h-full object-cover object-center group-hover:scale-[1.03] transition-transform duration-700 ease-out"
              loading="lazy"
            />
            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/70 via-transparent to-transparent opacity-80 group-hover:opacity-90 transition-opacity duration-300 pointer-events-none"></div>
            <div class="absolute bottom-4 left-4 right-4 z-10 text-white flex flex-col sm:flex-row sm:items-end justify-between gap-2">
              <div>
                <span class="text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded bg-brand-700 text-white mb-1 inline-block">
                  {{ photos[3].category }}
                </span>
                <p class="text-sm sm:text-base font-bold text-white leading-snug">
                  {{ photos[3].title }}
                </p>
              </div>
              <span class="text-xs text-slate-300 hidden sm:inline">Kampus AMIK Taruna</span>
            </div>
          </div>

        </div>

      </div>

    </div>
  </section>
</template>
