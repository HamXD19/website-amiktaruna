<script setup>
import { ref } from 'vue';
import AppButton from '../ui/AppButton.vue';

const props = defineProps({
  setting: {
    type: Object,
    default: () => ({})
  }
});

const isMapActive = ref(false);
</script>

<template>
  <section class="py-20 lg:py-28 bg-[#fbfcfb] border-b border-slate-200/60">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-14 items-center">
        
        <!-- Left Column: Editorial Location & Campus Information (5 cols) -->
        <div class="lg:col-span-5 flex flex-col items-start">
          
          <div class="mb-4">
            <span class="text-xs font-bold uppercase tracking-widest text-brand-800 bg-brand-50 px-3 py-1 rounded border border-brand-200/70">
              Kunjungan &amp; Alamat
            </span>
          </div>

          <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight leading-[1.18]">
            Kampus Strategis &amp;
            <span class="text-brand-800 block">Mudah Dijangkau.</span>
          </h2>

          <p class="mt-4 text-base text-slate-600 leading-relaxed">
            Terletak di pusat akses kota Probolinggo dengan fasilitas perkuliahan, laboratorium komputer terpadu, dan ruang administrasi terpusat.
          </p>

          <!-- Contact / Address Details -->
          <div class="mt-8 space-y-4 w-full text-xs sm:text-sm text-slate-700">
            
            <div v-if="setting?.alamat" class="flex items-start gap-3.5 pb-4 border-b border-slate-200/80">
              <div class="w-8 h-8 rounded-lg bg-brand-50 text-brand-700 flex items-center justify-center shrink-0 mt-0.5">
                <i class="fas fa-map-marker-alt text-xs"></i>
              </div>
              <div>
                <p class="font-bold text-slate-900">Alamat Kampus:</p>
                <p class="text-slate-600 mt-0.5 leading-relaxed">{{ setting.alamat }}</p>
              </div>
            </div>

            <div v-if="setting?.telepon" class="flex items-start gap-3.5 pb-4 border-b border-slate-200/80">
              <div class="w-8 h-8 rounded-lg bg-brand-50 text-brand-700 flex items-center justify-center shrink-0 mt-0.5">
                <i class="fas fa-phone-alt text-xs"></i>
              </div>
              <div>
                <p class="font-bold text-slate-900">Telepon / Layanan:</p>
                <a :href="'tel:' + setting.telepon" class="text-brand-800 font-semibold hover:underline mt-0.5 block">
                  {{ setting.telepon }}
                </a>
              </div>
            </div>

            <div v-if="setting?.email" class="flex items-start gap-3.5">
              <div class="w-8 h-8 rounded-lg bg-brand-50 text-brand-700 flex items-center justify-center shrink-0 mt-0.5">
                <i class="fas fa-envelope text-xs"></i>
              </div>
              <div>
                <p class="font-bold text-slate-900">Surat Elektronik:</p>
                <a :href="'mailto:' + setting.email" class="text-brand-800 font-semibold hover:underline mt-0.5 block">
                  {{ setting.email }}
                </a>
              </div>
            </div>

          </div>

          <div class="mt-8">
            <AppButton
              :href="'https://www.google.com/maps/search/?api=1&query=' + encodeURIComponent(setting?.alamat || 'AMIK Taruna Probolinggo')"
              variant="secondary"
              size="md"
              :external="true"
            >
              Petunjuk Arah Google Maps ↗
            </AppButton>
          </div>

        </div>

        <!-- Right Column: Supporting Framed Touch-Safe Map (7 cols) -->
        <div class="lg:col-span-7">
          <div class="relative rounded-xl overflow-hidden shadow-card border border-slate-200/90 bg-slate-100 aspect-[16/10]">
            <iframe
              src="https://www.google.com/maps?q=AMIK%20Taruna%20Probolinggo&output=embed"
              class="w-full h-full border-0"
              :class="isMapActive ? 'pointer-events-auto' : 'pointer-events-none sm:pointer-events-auto'"
              allowfullscreen=""
              loading="lazy"
              referrerpolicy="no-referrer-when-downgrade"
              title="Peta Lokasi Kampus AMIK Taruna"
            ></iframe>

            <!-- Mobile Touch Overlay (Prevents scroll trap while swiping on phone) -->
            <div
              v-if="!isMapActive"
              class="absolute inset-0 bg-slate-900/10 sm:hidden flex items-center justify-center backdrop-blur-[1px]"
              @click="isMapActive = true"
            >
              <button
                type="button"
                class="bg-white/95 text-slate-900 px-4 py-2 rounded-lg text-xs font-bold shadow-md border border-slate-200 inline-flex items-center gap-2"
              >
                <i class="fas fa-hand-pointer text-brand-700"></i>
                Sentuh untuk Geser Peta
              </button>
            </div>
          </div>
          
          <p class="mt-2.5 text-[11px] text-slate-400 text-right">
            Kampus AMIK Taruna Probolinggo, Jawa Timur
          </p>
        </div>

      </div>

    </div>
  </section>
</template>
