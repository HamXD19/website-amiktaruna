<script setup>
import AppButton from '../ui/AppButton.vue';

defineProps({
  setting: {
    type: Object,
    default: () => ({})
  }
});
</script>

<template>
  <section class="py-16 lg:py-24 relative overflow-hidden">
    
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
      
      <!-- Elevated Solid White CTA Card -->
      <div class="bg-white rounded-3xl p-8 sm:p-14 lg:p-16 shadow-2xl border border-slate-200/80 text-center relative z-10">
        
        <!-- Eyebrow Pill -->
        <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full text-xs font-bold uppercase tracking-widest bg-brand-50 text-brand-800 border border-brand-200/70 mb-6">
          <span class="w-1.5 h-1.5 rounded-full bg-brand-700"></span>
          Penerimaan Mahasiswa Baru 2026/2027
        </div>

        <!-- Strong Closing Statement Headline -->
        <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight text-slate-900 leading-[1.15] max-w-3xl mx-auto">
          Mulai langkah nyatamu
          <span class="text-brand-800 block mt-1">di dunia teknologi &amp; digital.</span>
        </h2>

        <!-- Concise Academic Lead -->
        <p class="mt-6 text-base sm:text-lg text-slate-600 leading-relaxed max-w-2xl mx-auto">
          Daftarkan dirimu di AMIK Taruna. Dapatkan pembekalan komputasi terapan, bimbingan dosen berpengalaman, dan sertifikasi keahlian siap industri.
        </p>

        <!-- Conversion Actions -->
        <div class="mt-9 flex flex-wrap items-center justify-center gap-4">
          <AppButton href="/pmb" variant="accent" size="lg">
            <template #prefix>
              <i class="fas fa-graduation-cap"></i>
            </template>
            Informasi Pendaftaran PMB
            <template #suffix>→</template>
          </AppButton>

          <a
            v-if="setting?.telepon"
            :href="'https://wa.me/' + setting.telepon.replace(/[^0-9]/g, '') + '?text=' + encodeURIComponent('Halo Admin PMB AMIK Taruna, saya ingin konsultasi mengenai pendaftaran mahasiswa baru.')"
            target="_blank"
            rel="noopener"
            class="inline-flex items-center gap-2.5 px-6 py-3.5 rounded-xl font-bold text-sm sm:text-base text-emerald-800 bg-emerald-50 hover:bg-emerald-100 border border-emerald-200 transition-colors shadow-sm"
          >
            <i class="fab fa-whatsapp text-emerald-600 text-lg"></i>
            <span>Konsultasi WhatsApp</span>
          </a>
        </div>

        <!-- Quick Trust Indicators -->
        <div class="mt-12 pt-8 border-t border-slate-200/80 flex flex-wrap items-center justify-center gap-6 sm:gap-10 text-xs text-slate-600 font-semibold">
          <span>✓ Akreditasi BAN-PT Resmi</span>
          <span>✓ Biaya Kuliah Terjangkau</span>
          <span>✓ Beasiswa Prestasi &amp; KIP-K</span>
          <span>✓ Konsultasi Program Studi Bebas Biaya</span>
        </div>

      </div>

    </div>
  </section>
</template>
