<script setup>
import { computed, ref } from 'vue';

const props = defineProps({
  akreditasi: {
    type: Array,
    default: () => []
  }
});

const previewImage = ref(null);

const primaryAkreditasi = computed(() => {
  return props.akreditasi && props.akreditasi.length > 0 ? props.akreditasi[0] : null;
});

const secondaryAkreditasi = computed(() => {
  return props.akreditasi && props.akreditasi.length > 1 ? props.akreditasi.slice(1) : [];
});

const openPreview = (img) => {
  if (img) previewImage.value = img;
};

const closePreview = () => {
  previewImage.value = null;
};
</script>

<template>
  <section id="akreditasi" class="py-20 lg:py-28 bg-white border-b border-slate-200/70 scroll-mt-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      
      <!-- Section Header Card -->
      <div class="card rounded-3xl p-6 sm:p-10 mb-12 flex flex-col md:flex-row md:items-end justify-between gap-6 relative z-10">
        <div class="max-w-2xl">
          <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
            Jaminan Mutu Institusi
          </span>
          <h2 class="mt-4 text-3xl sm:text-4xl lg:text-[40px] font-extrabold text-white tracking-tight leading-[1.18]">
            Akreditasi &amp; Legalitas Resmi
          </h2>
          <p class="mt-4 text-base text-slate-300 leading-relaxed">
            Pengakuan formal kelayakan akademik dan tata kelola perguruan tinggi oleh badan akreditasi nasional.
          </p>
        </div>

        <div class="shrink-0 self-start md:self-auto text-xs font-mono text-emerald-300 bg-emerald-950/70 px-4 py-2.5 rounded-xl border border-emerald-500/30">
          <i class="fas fa-shield-alt text-emerald-400 me-1.5"></i>
          Terdaftar di PDDIKTI Kemendikbudristek
        </div>
      </div>

      <!-- Empty State -->
      <div
        v-if="!primaryAkreditasi"
        class="card rounded-3xl p-16 text-center text-slate-300"
      >
        <i class="fas fa-certificate text-4xl text-emerald-400 mb-3 block"></i>
        <p class="font-bold text-lg text-white">Data akreditasi sedang dalam pembaruan.</p>
        <p class="text-sm text-slate-400 mt-1">Silakan hubungi bagian administrasi akademik untuk informasi legalitas.</p>
      </div>

      <!-- Main / Dominant Current Accreditation Card -->
      <div v-else class="space-y-12">
        <div class="card rounded-3xl p-6 sm:p-10 lg:p-12 relative overflow-hidden">
          
          <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">
            
            <!-- Left Info (7 cols) -->
            <div class="lg:col-span-7 flex flex-col">
              
              <div class="flex flex-wrap items-center gap-3 mb-5">
                <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
                  <i class="fas fa-check-circle text-amber-400 text-[11px]"></i>
                  Status: Terakreditasi {{ primaryAkreditasi.peringkat || 'Resmi' }}
                </span>
                
                <span class="text-xs font-mono font-semibold text-slate-300 bg-emerald-950/60 px-3 py-1.5 rounded-full border border-emerald-500/20">
                  Tahun Penetapan {{ primaryAkreditasi.tahun }}
                </span>
              </div>

              <h3 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight leading-snug">
                {{ primaryAkreditasi.judul || 'Akreditasi Institusi Perguruan Tinggi' }}
              </h3>

              <p class="mt-4 text-slate-300 leading-relaxed text-base sm:text-lg">
                AMIK Taruna secara resmi mengantongi status akreditasi institusi dengan peringkat 
                <strong class="text-white font-bold">{{ primaryAkreditasi.peringkat || 'Baik' }}</strong>. 
                Sertifikasi ini menegaskan kepatuhan terhadap standar nasional pendidikan, penelitian, dan pengabdian masyarakat.
              </p>

              <!-- Validity & Details Grid -->
              <div class="mt-8 pt-6 border-t border-emerald-500/20 grid grid-cols-2 sm:grid-cols-3 gap-6">
                <div>
                  <span class="text-xs font-mono uppercase text-slate-400 block mb-1">Periode Berlaku</span>
                  <span class="text-sm font-bold text-white">{{ primaryAkreditasi.deskripsi || (primaryAkreditasi.tahun + ' — Seterusnya') }}</span>
                </div>
                <div>
                  <span class="text-xs font-mono uppercase text-slate-400 block mb-1">Peringkat Mutu</span>
                  <span class="text-sm font-bold text-emerald-400">{{ primaryAkreditasi.peringkat || 'Baik' }}</span>
                </div>
                <div class="col-span-2 sm:col-span-1">
                  <span class="text-xs font-mono uppercase text-slate-400 block mb-1">Verifikasi</span>
                  <span class="text-sm font-bold text-white">BAN-PT / LAM</span>
                </div>
              </div>

              <div class="mt-8 flex items-center gap-4">
                <button
                  v-if="primaryAkreditasi.gambar"
                  type="button"
                  @click="openPreview('/uploads/' + primaryAkreditasi.gambar)"
                  class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs sm:text-sm font-bold bg-emerald-500/20 text-emerald-300 hover:bg-emerald-500/30 border border-emerald-500/30 shadow-xs transition-colors"
                >
                  <i class="fas fa-search-plus text-emerald-400"></i>
                  <span>Perbesar Dokumen SK</span>
                </button>
              </div>

            </div>

            <!-- Right Visual Certificate Frame (5 cols) -->
            <div class="lg:col-span-5">
              <div
                class="rounded-2xl overflow-hidden bg-slate-900/60 border border-emerald-500/25 shadow-md relative group cursor-pointer aspect-[4/3] flex items-center justify-center p-3"
                @click="primaryAkreditasi.gambar ? openPreview('/uploads/' + primaryAkreditasi.gambar) : null"
              >
                <img
                  v-if="primaryAkreditasi.gambar"
                  :src="'/uploads/' + primaryAkreditasi.gambar"
                  :alt="primaryAkreditasi.judul"
                  class="w-full h-full object-contain group-hover:scale-[1.02] transition-transform duration-300 rounded-lg"
                  loading="lazy"
                />
                <div
                  v-else
                  class="flex flex-col items-center justify-center text-slate-400 p-8 text-center"
                >
                  <i class="fas fa-award text-5xl text-emerald-400/40 mb-3"></i>
                  <span class="text-xs font-semibold text-slate-300">Dokumen Sertifikat Resmi</span>
                </div>

                <div
                  v-if="primaryAkreditasi.gambar"
                  class="absolute inset-0 bg-emerald-950/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center text-white text-xs font-bold gap-2 backdrop-blur-[2px]"
                >
                  <i class="fas fa-expand text-emerald-300"></i>
                  <span>Klik untuk melihat</span>
                </div>
              </div>
            </div>

          </div>

        </div>

        <!-- Historical Archive Grid (If any secondary items exist) -->
        <div v-if="secondaryAkreditasi.length > 0" class="pt-6">
          <h4 class="text-sm font-bold uppercase tracking-wider text-slate-300 mb-6">
            Arsip Akreditasi Sebelumnya
          </h4>
          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <div
              v-for="item in secondaryAkreditasi"
              :key="item.id"
              class="card rounded-2xl p-6 flex flex-col justify-between"
            >
              <div>
                <div class="flex items-center justify-between text-xs text-slate-400 mb-2">
                  <span class="font-bold text-emerald-400">Tahun {{ item.tahun }}</span>
                  <span class="font-mono text-slate-300">{{ item.peringkat }}</span>
                </div>
                <h5 class="text-base font-bold text-white">{{ item.judul }}</h5>
                <p class="text-xs text-slate-300 mt-2">{{ item.deskripsi }}</p>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

    <!-- Image Lightbox Modal for Certificate Preview -->
    <div
      v-if="previewImage"
      class="fixed inset-0 z-50 bg-slate-950/80 backdrop-blur-xs flex items-center justify-center p-4"
      @click="closePreview"
    >
      <div
        class="relative max-w-4xl max-h-[90vh] bg-white rounded-2xl p-2 sm:p-4 shadow-2xl overflow-hidden"
        @click.stop
      >
        <button
          type="button"
          @click="closePreview"
          class="absolute top-4 right-4 w-9 h-9 rounded-full bg-slate-900 text-white flex items-center justify-center hover:bg-slate-700 transition-colors z-10"
          aria-label="Tutup"
        >
          ✕
        </button>
        <img
          :src="previewImage"
          alt="Sertifikat Akreditasi"
          class="max-h-[80vh] w-auto mx-auto object-contain rounded-lg"
        />
      </div>
    </div>

  </section>
</template>
