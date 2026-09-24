<script setup>
import { ref, computed } from 'vue';

const props = defineProps({
  programs: {
    type: Array,
    default: () => []
  }
});

const searchQuery = ref('');

// Filter programs reactively
const filteredPrograms = computed(() => {
  if (!searchQuery.value.trim()) return props.programs;
  const q = searchQuery.value.toLowerCase().trim();
  return props.programs.filter(p => {
    const nama = (p.nama_prodi || '').toLowerCase();
    const tagline = (p.tagline || '').toLowerCase();
    const deskripsi = (p.deskripsi || '').toLowerCase();
    return nama.includes(q) || tagline.includes(q) || deskripsi.includes(q);
  });
});

// Helper for Program Code Monogram
const getProgramCode = (namaProdi) => {
  if (!namaProdi) return 'D3';
  const clean = namaProdi.toLowerCase();
  if (clean.includes('akuntansi')) return 'SIA';
  if (clean.includes('teknologi')) return 'TI';
  if (clean.includes('sistem')) return 'SI';
  return namaProdi.split(' ').map(w => w[0]).join('').toUpperCase().slice(0, 3);
};
</script>

<template>
  <section class="py-16 sm:py-24 relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      
      <!-- Section Header & Filter -->
      <div class="flex flex-col md:flex-row md:items-end justify-between mb-14 lg:mb-20 gap-6">
        <div class="max-w-2xl">
          <span class="inline-flex items-center gap-1.5 text-xs font-bold uppercase tracking-widest text-emerald-300 bg-emerald-500/20 px-3 py-1 rounded-full border border-emerald-500/30">
            Katalog Keahlian Vokasi
          </span>
          <h2 class="mt-4 text-2xl sm:text-3xl lg:text-[40px] font-extrabold text-white tracking-tight leading-[1.18]">
            Pilihan Program Studi D3
          </h2>
          <p class="mt-4 text-base text-slate-300 leading-relaxed">
            Setiap program studi berfokus pada penguasaan terapan, pembekalan sertifikasi kompetensi, dan relevansi langsung dengan kebutuhan dunia kerja.
          </p>
        </div>

        <!-- Search Input -->
        <div class="w-full md:w-72 shrink-0">
          <div class="relative">
            <i class="fas fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-emerald-400/70 text-xs"></i>
            <input
              v-model="searchQuery"
              type="text"
              placeholder="Cari program studi..."
              class="w-full pl-9 pr-8 py-2.5 text-xs sm:text-sm rounded-xl border border-emerald-500/25 bg-emerald-950/70 text-white placeholder-slate-400 focus:outline-none focus:border-emerald-400 focus:ring-1 focus:ring-emerald-400 transition-colors"
            />
            <button
              v-if="searchQuery"
              type="button"
              @click="searchQuery = ''"
              class="absolute right-3 top-1/2 -translate-y-1/2 text-xs text-slate-400 hover:text-white"
            >
              ✕
            </button>
          </div>
        </div>
      </div>

      <!-- Empty State -->
      <div
        v-if="filteredPrograms.length === 0"
        class="card text-center py-20 px-4 rounded-2xl border border-emerald-500/20 shadow-lg max-w-2xl mx-auto"
      >
        <div class="w-16 h-16 rounded-full bg-emerald-500/20 text-emerald-300 flex items-center justify-center mx-auto mb-4 border border-emerald-500/30">
          <i class="fas fa-graduation-cap text-2xl"></i>
        </div>
        <h3 class="text-lg font-bold text-white">Program Studi Tidak Ditemukan</h3>
        <p class="text-sm text-slate-300 mt-2 leading-relaxed">
          Tidak ada program studi yang cocok dengan kata kunci pencarian Anda.
        </p>
        <button
          type="button"
          @click="searchQuery = ''"
          class="mt-6 inline-flex items-center gap-2 px-4 py-2 rounded-lg text-xs font-bold bg-[#16a34a] text-white hover:bg-[#15803d] transition-colors"
        >
          Reset Pencarian
        </button>
      </div>

      <!-- Alternating Editorial Program Showcase -->
      <div v-else class="space-y-16 sm:space-y-24">
        <article
          v-for="(prodi, index) in filteredPrograms"
          :key="prodi.id"
          class="card rounded-2xl border border-emerald-500/20 p-6 sm:p-10 lg:p-12 shadow-xl transition-all hover:border-emerald-400/60 group"
        >
          <div
            class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-14 items-center"
            :class="index % 2 === 1 ? 'lg:flex-row-reverse' : ''"
          >
            
            <!-- Visual Column (5 cols) -->
            <div
              class="lg:col-span-5"
              :class="index % 2 === 1 ? 'lg:order-2' : 'lg:order-1'"
            >
              <div class="rounded-xl overflow-hidden border border-emerald-500/25 shadow-xs bg-slate-900 aspect-[4/3] relative">
                <!-- If thumbnail photo available -->
                <img
                  v-if="prodi.thumbnail"
                  :src="'/uploads/program_studi/' + prodi.thumbnail"
                  :alt="prodi.nama_prodi"
                  class="w-full h-full object-cover group-hover:scale-[1.03] transition-transform duration-700 ease-out"
                  loading="lazy"
                  @error="(e) => { e.target.style.display = 'none'; }"
                />
                
                <!-- Elegant Monogram Academic Fallback -->
                <div
                  v-else
                  class="w-full h-full flex flex-col justify-between p-6 sm:p-8 bg-gradient-to-br from-[#052e16] to-[#14532d] text-white relative overflow-hidden"
                >
                  <div class="absolute inset-0 bg-[linear-gradient(to_right,#ffffff_1px,transparent_1px),linear-gradient(to_bottom,#ffffff_1px,transparent_1px)] bg-[size:2rem_2rem] opacity-5 pointer-events-none"></div>

                  <div class="flex items-center justify-between relative z-10">
                    <span class="text-xs font-mono tracking-widest uppercase text-emerald-300 font-bold">
                      AMIK Taruna
                    </span>
                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-white/10 text-white border border-white/20">
                      Diploma III
                    </span>
                  </div>

                  <div class="my-auto text-center py-4 relative z-10">
                    <span class="font-mono text-5xl sm:text-6xl font-extrabold tracking-tight text-white/90 block">
                      {{ getProgramCode(prodi.nama_prodi) }}
                    </span>
                    <span class="text-xs font-medium text-emerald-200 mt-2 block">
                      {{ prodi.nama_prodi }}
                    </span>
                  </div>

                  <div class="flex items-center justify-between text-[11px] text-emerald-200/80 border-t border-white/10 pt-3 relative z-10 font-medium">
                    <span>Gelar A.Md.</span>
                    <span>3 Tahun (6 Semester)</span>
                  </div>
                </div>

                <!-- Bottom Vignette when image present -->
                <div v-if="prodi.thumbnail" class="absolute inset-0 bg-gradient-to-t from-slate-950/60 via-transparent to-transparent pointer-events-none"></div>
              </div>
            </div>

            <!-- Content Column (7 cols) -->
            <div
              class="lg:col-span-7 flex flex-col items-start"
              :class="index % 2 === 1 ? 'lg:order-1' : 'lg:order-2'"
            >
              <!-- Number & Accreditation Badge -->
              <div class="flex flex-wrap items-center gap-3 mb-4">
                <span class="font-mono text-xs font-bold text-emerald-300 bg-emerald-500/20 px-2.5 py-1 rounded border border-emerald-500/30">
                  {{ String(index + 1).padStart(2, '0') }} / D3 PRODI
                </span>
                
                <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-emerald-300 bg-emerald-500/15 px-3 py-1 rounded-full border border-emerald-500/25">
                  <i class="fas fa-certificate text-[11px]"></i>
                  Akreditasi {{ prodi.akreditasi || 'Baik' }}
                </span>
              </div>

              <!-- Program Name -->
              <h3 class="text-2xl sm:text-3xl font-extrabold text-white group-hover:text-emerald-300 transition-colors leading-tight">
                {{ prodi.nama_prodi }}
              </h3>

              <!-- Tagline -->
              <p v-if="prodi.tagline" class="text-xs sm:text-sm font-semibold text-emerald-400 uppercase tracking-wider mt-2">
                {{ prodi.tagline }}
              </p>

              <!-- Description -->
              <p class="mt-4 text-base text-slate-300 leading-relaxed">
                {{ prodi.deskripsi || 'Program studi vokasi berorientasi pada penguasaan keahlian praktis, logika pemrograman terapan, dan kesiapan berkarier di dunia industri teknologi.' }}
              </p>

              <!-- Metadata Summary Chips -->
              <div class="mt-6 pt-6 border-t border-emerald-500/20 w-full grid grid-cols-2 sm:grid-cols-3 gap-4 text-xs text-slate-300">
                <div>
                  <span class="text-slate-400 block font-mono uppercase text-[10px]">Jenjang</span>
                  <span class="font-bold text-white">Diploma III (D3)</span>
                </div>
                <div>
                  <span class="text-slate-400 block font-mono uppercase text-[10px]">Gelar Lulusan</span>
                  <span class="font-bold text-emerald-300">A.Md.</span>
                </div>
                <div class="col-span-2 sm:col-span-1">
                  <span class="text-slate-400 block font-mono uppercase text-[10px]">Waktu Tempuh</span>
                  <span class="font-bold text-white">6 Semester</span>
                </div>
              </div>

              <!-- Action Link to Detail Page -->
              <div class="mt-8">
                <a
                  :href="'/akademik/' + prodi.slug"
                  class="inline-flex items-center gap-2.5 px-6 py-3.5 rounded-xl font-bold text-xs sm:text-sm bg-[#16a34a] hover:bg-[#15803d] text-white shadow-xs hover:shadow-sm transition-all duration-200 hover:-translate-y-0.5 group/link"
                >
                  <span>Lihat Kurikulum &amp; Detail Prodi</span>
                  <span class="group-hover/link:translate-x-1 transition-transform">→</span>
                </a>
              </div>

            </div>

          </div>
        </article>
      </div>

    </div>
  </section>
</template>
